<?php


namespace App\Controller;

use App\Entity\Contacts;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\PrivateMessage;
use App\Entity\PublicMessage;
use App\Entity\School;
use App\Entity\Classroom;
use App\Form\PublicMessageType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ClassRoomController
 * @package App\Controller
 * @Route("classroom/")
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


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->schoolRepository = $entityManager->getRepository(School::class);
        $this->classRoomRepository = $entityManager->getRepository(Classroom::class);
        $this->publicMessageRepository = $entityManager->getRepository(PublicMessage::class);
    }
    /**
     * @Route("/classroom/{id}", name="classroom_id")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function classroom(Request $request, $id){

        $classroom = $this->classRoomRepository->findOneById($id);
    }

    /**
     * @param Request $request
     * @Route("/teacher/{classReceiver}", name="class_message")
     */
    public function sendMessage(Request $request, $classReceiver){


        $classReceiver = $this->classRoomRepository->findOneById($classReceiver);


        $message = new PublicMessage();
        $date = new \DateTime();
        $message->setSendAt($date);

        $message->setReceiver($classReceiver);
        $form = $this->createForm(PublicMessageType::class, $message, array('classroom' => $this->getUser()->getClassroom())) ;
        $form->handleRequest($request);

        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($message);

            $this->entityManager->flush();

            $this->addFlash('success', 'Message envoyé');
            //return $this->redirectToRoute('conversation',array("contact" => $receiver));
        }

        return $this->render('/public_message/message_Form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}