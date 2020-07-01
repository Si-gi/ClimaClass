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

        if($this->getUser()->getRoles() != "ROLE_TEACHER"){
            $this->redirectToRoute("classroom_messages");
        }
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

    /**
     * @Route("classroom/{classroom_contact}", name="classroom_conversation")
     */
    public function seeMessages(Request $request, $classroom_contact){


        //$userSender = $this->UserRepository->findOneByUsername($user->getUserName());
        $contacts = $this->ContactsRepository->findByIdUser($user->getId());
        $receiver = $this->UserRepository->findOneById($classroom_contact);
        $messages = $this->privateMessageRepository->getConv($receiver->getId(), $user->getId());

        $messages = $this->privateMessageRepository->findBy(
            [
                'receiver' => $receiver,
                'sender' =>$user
            ]
        );

        return $this->render('private_message/Message.html.twig',[
            "messages" => $messages,
            "user" => $userSender,
        ]);
    }

    /**
     * @Route("classroom_messages/{classroom_id}", name="classroom_messages")
     */
    public function seeAllMessages(Request $request, $classroom_id){



        $classroom = $this->publicMessageRepository->findOneById($classroom_id);

        $messages = $this->publicMessageRepository->findBy(
            [
                'receiver' => $classroom_id,
                'sender' =>$classroom_id
            ]
        );
        $messages = $this->publicMessageRepository->getConv($classroom_id);
        return $this->render('public_message/allMessages.html.twig',[
            "messages" => $messages,
            "classroom" => $classroom,
        ]);
    }
}