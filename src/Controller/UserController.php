<?php


namespace App\Controller;


use App\Entity\Classroom;
use App\Entity\Contacts;
use App\Entity\PrivateMessage;
use App\Entity\PublicMessage;
use App\Entity\School;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PrivateMessageType;
use App\Repository\PrivateMessageRepository;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/teacher", name="user_controller")
 */
class UserController extends AbstractController
{

    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $schoolRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $classRoomRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $privateMessageRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $publicMessageRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $ContactsRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $UserRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->UserRepository = $entityManager->getRepository(User::class);
        $this->schoolRepository = $entityManager->getRepository(School::class);
        $this->classRoomRepository = $entityManager->getRepository(Classroom::class);
        $this->privateMessageRepository = $entityManager->getRepository(PrivateMessage::class);
        $this->publicMessageRepository = $entityManager->getRepository(PublicMessage::class);
        $this->ContactsRepository = $entityManager->getRepository(Contacts::class);
    }

    /**
     * @Route("messages/{receiver}",name="messages_form")
     */
    public function sendMessage(Request $request, $receiver){

        $userSender = $this->UserRepository->findOneByUsername($this->getUser()->getUserName());
        $userReceiver = $this->UserRepository->findOneById($receiver);
        $havecontact = $this->haveContact($userReceiver);

        $message = new PrivateMessage();
        $date = new \DateTime();
        $message->setSendAt($date);
        $message->setSender($userSender);
        $message->setReceiver($userReceiver);
        $form = $this->createForm(PrivateMessageType::class, $message);
        $form->handleRequest($request);

        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {

            if($havecontact == false){
                $contact = new Contacts();
                $contact->setIdUser($userSender);
                $contact->setIdContact($userReceiver);
                $this->entityManager->persist($contact);
                $this->entityManager->flush();

                $contact2 = new Contacts();
                $contact2->setIdUser($userReceiver);
                $contact2->setIdContact($userSender);
                $this->entityManager->persist($contact2);
                $this->entityManager->flush();

            }
            $this->entityManager->persist($message);

            $this->entityManager->flush();

            $this->addFlash('success', 'Message envoyé');
            return $this->redirectToRoute('conversation',array("contact" => $receiver));
        }

        return $this->render('/message/Message_Form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    // Verifie si les utilisateurs ont déjà communiqués ou non (pour le menu des contacts) Attention bug potentiel (à vérifier)
    public function haveContact($userReceiver){
        $haveContacts = $this->ContactsRepository->getContactWhere($this->getUser()->getUserName(),$userReceiver);
        if( $haveContacts )
            return true;
        else{
            return false;
        }
    }

    /**
     * @Route("conversation/{contact}", name="conversation")
     */
    public function seeMessages($contact,Request $request){

        $user= $this->getUser();
        $userSender = $this->UserRepository->findOneByUsername($user->getUserName());
        $contacts = $this->ContactsRepository->findByIdUser($user->getId());
        $receiver = $this->UserRepository->findOneById($contact);
        $messages = $this->privateMessageRepository->getConv($receiver->getId(), $user->getId());
        //var_dump($messages);

        $messages = $this->privateMessageRepository->findBy(
            [
                'receiver' => $receiver,
              'sender' =>$user
            ]
        );

        $message = new PrivateMessage();
        $date = new \DateTime();
        $message->setSendAt($date);
        $message->setSender($userSender);
        $message->setReceiver($receiver);
        $form = $this->createForm(PrivateMessageType::class, $message);
        $form->handleRequest($request);

        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($message);

            $this->entityManager->flush();

            $this->addFlash('success', 'Message envoyé');
            return $this->redirectToRoute('conversation', array("contact" => $receiver->getId()));
        }

        return $this->render('message/Message.html.twig',[
            "messages" => $messages,
            "user" => $userSender,
            "contact" => $receiver,
            'form' => $form->createView(),
            'list_contact' => $contacts,
        ]);
    }


    /**
     * @Route("contacts",  name="contacts")
     */
    public function seeContact(){
        $contacts = $this->ContactsRepository->findByIdUser($this->getUser()->getId());
        //$contacts = $this->ContactsRepository->findByIdContact($this->getUser()->getId());

        return $this->render('/Messages/Contacts.html.twig',[
            'contacts' => $contacts,
        ]);
    }

}