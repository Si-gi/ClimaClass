<?php


namespace App\Controller;

use App\Entity\Contacts;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\PrivateMessage;
use App\Entity\PublicMessage;
use App\Entity\File;
use App\Entity\School;
use App\Entity\Classroom;
use App\Entity\Publication;
use App\Form\PublicMessageType;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ClassRoomController
 * @package App\Controller
 */
class ClassRoomController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $schoolRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $classRoomRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $publicMessageRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $publicationRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $fileRepository;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->schoolRepository = $entityManager->getRepository(School::class);
        $this->classRoomRepository = $entityManager->getRepository(Classroom::class);
        $this->publicMessageRepository = $entityManager->getRepository(PublicMessage::class);
        $this->publicationRepository = $entityManager->getRepository(Publication::class);
        $this->fileRepository = $entityManager->getRepository(File::class);
    }
    /**
     * @Route("/classroomProfil/{id}", name="classroom_profil")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function classroom(Request $request, PublicationRepository $publicationRepository, PaginatorInterface $paginator, $id)
    {

        $temperatures = [];
        $windSpeeds = [];
        $rainLevels = [];

        $measures = $this->getDoctrine()->getRepository(Classroom::class)->find($id)->getMeasures();

        for ($i = 0; $i < count($measures); $i++) {

            $temperatures[$i] = ['date' => $measures[$i]->getMeasurementDate()->format('Y-m-d'), 'value' => $measures[$i]->getTemperature()];
            $windSpeeds[$i] = ['date' => $measures[$i]->getMeasurementDate()->format('Y-m-d'), 'value' => $measures[$i]->getWindSpeed()];
            $rainLevels[$i] = ['date' => $measures[$i]->getMeasurementDate()->format('Y-m-d'), 'value' => $measures[$i]->getRainLevel()];
        }


        $classroom = $this->classRoomRepository->find($id);
        $donnees = $publicationRepository->findBy(['classroom' => $id],['date' => 'DESC']);
        $publications = $paginator->paginate($donnees, $request->query->getInt('page', 1), 4);
        $nbPages = count($donnees) / 4;
        return $this->render('classroom/show.html.twig', [
            'class' => $classroom,
            'publications' => $publications,
            'temperatures' => $temperatures,
            'windSpeeds' => $windSpeeds,
            'rainLevels' => $rainLevels,
            'pages'=> ceil($nbPages),

        ]);
    }

    /**
     * @param $id_releve
     * @Route("files/{id_releve}", name="seeFiles")
     */
    public function seeFiles($id_releve){
        $files = $this->fileRepository->findBy(['publication' => $id_releve]);

        return $this->render("publication/download.html.twig",["files" => $files]);
    }

    /**
     * @param Request $request
     * @Route("/teacher/{classReceiver}", name="class_message")
     */
    public function sendMessage(Request $request, $classReceiver)
    {
        if($this->getUser()->getRoles() != "ROLE_TEACHER" ||$this->getUser()->getRoles() != "ROLE_ADMIN"|| $this->getUser()->getRoles() != "ROLE_SUPER_ADMIN"){
            $this->redirectToRoute("classroom_messages", array("classroom_id" => $this->getUser()->getClassroom()[0]));
        }
        $classReceiver = $this->classRoomRepository->findOneById($classReceiver);


        $message = new PublicMessage();
        $date = new \DateTime();
        $message->setSendAt($date);

        $message->setReceiver($classReceiver);
        $form = $this->createForm(PublicMessageType::class, $message, array('classroom' => $this->getUser()->getClassroom()));
        $form->handleRequest($request);

        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($message);

            $this->entityManager->flush();

            $this->addFlash('success', 'Message envoyé');
            return $this->redirectToRoute('classroom_conversation',array("classroom_contact_a" => $message->getSender()->getId(),
                "classroom_contact_b" =>  $message->getReceiver()->getId()));
        }

        return $this->render('/public_message/message_Form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("classroom/{classroom_contact_a}/{classroom_contact_b}", name="classroom_conversation")
     */
    public function seeMessages(Request $request, $classroom_contact_a, $classroom_contact_b)
    {


        $classroom_user = $this->getUser()->getClassroom()[0];
        $classReceiver = $this->classRoomRepository->findOneById($classroom_contact_b);
        $classSender = $this->classRoomRepository->findOneById($classroom_contact_a);
        $messages = $this->publicMessageRepository->getConv($classroom_contact_a, $classroom_contact_b);

        return $this->render('public_message/message_class.html.twig', [
            "messages" => $messages,
            "classSender" => $classSender,
            "classReceiver" => $classReceiver
        ]);
    }

    /**
     * @Route("mymessages/", name="mymessage")
     */
    public function myMessages()
    {

        if ($this->getUser()->getRoles() != "ROLES_TEACHER") {
            $classroom = $this->getUser()->getClassroom()[0];
            return  $this->redirectToRoute("classroom_messages", ['classroom_id' => $classroom->getId()]);
        }
    }
    /**
     * @Route("classroom_messages/{classroom_id}", name="classroom_messages")
     */
    public function seeAllMessages(Request $request, $classroom_id)
    {



        $classroom = $this->publicMessageRepository->findOneById($classroom_id);
        $messages = $this->publicMessageRepository->getAllConv($classroom_id);
        return $this->render('public_message/allMessages.html.twig', [
            "messages" => $messages,
            "classroom" => $classroom,
        ]);
    }
}
