<?php

namespace App\Controller;

use App\Entity\PublicMessage;
use App\Form\PublicMessageType;
use App\Repository\PublicMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/public/message")
 */
class PublicMessageController extends AbstractController
{
    /**
     * @Route("/", name="public_message_index", methods={"GET"})
     */
    public function index(PublicMessageRepository $publicMessageRepository): Response
    {
      $messages = $publicMessageRepository->findMessageRecus(2);
      //dd($messages);
      $classId=2;
      $messageRecus=$publicMessageRepository->findBy(
        ['idClasseDestinataire' => $classId]);
      $messageEnvoye=$publicMessageRepository->findBy(
        ['idClasseEmeteur' => $classId]);
        return $this->render('public_message/index.html.twig', [
            'messages_recus' => $messages,

        ]);

    }

    /**
     * @Route("/new", name="public_message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $publicMessage = new PublicMessage();
        $form = $this->createForm(PublicMessageType::class, $publicMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publicMessage);
            $entityManager->flush();

            return $this->redirectToRoute('public_message_index');
        }

        return $this->render('public_message/new.html.twig', [
            'public_message' => $publicMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="public_message_show", methods={"GET"})
     */
    public function show(PublicMessage $publicMessage): Response
    {
        return $this->render('public_message/show.html.twig', [
            'public_message' => $publicMessage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="public_message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PublicMessage $publicMessage): Response
    {
        $form = $this->createForm(PublicMessageType::class, $publicMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('public_message_index');
        }

        return $this->render('public_message/edit.html.twig', [
            'public_message' => $publicMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="public_message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PublicMessage $publicMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publicMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('public_message_index');
    }
}
