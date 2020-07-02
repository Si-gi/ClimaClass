<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Entity\Classroom;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="publication_index", methods={"GET"})
     */
    public function index(Request $request,PublicationRepository $publicationRepository,PaginatorInterface $paginator): Response
    {
      $publis=$publicationRepository->findBy([],['date' => 'DESC']);
      $publications = $paginator->paginate($publis,$request->query->getInt('page', 1),5);
      $nbPages = count($publis) / 5;
        return $this->render('publication/showAll.html.twig', [
            'publications' => $publications,
            'pages'=> ceil($nbPages),

        ]);



    }


    // /**
    //  * @Route("/new", name="publication_new", methods={"GET","POST"})
    //  */
    // public function new(Request $request): Response
    // {
    //     $publication = new Publication();
    //     $form = $this->createForm(PublicationType::class, $publication);
    //     $form->handleRequest($request);
    //
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($publication);
    //         $entityManager->flush();
    //
    //         return $this->redirectToRoute('publication_index');
    //     }
    //
    //     return $this->render('publication/new.html.twig', [
    //         'publication' => $publication,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/{id}", name="publication_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/class/{id}", name="publication_classe", methods={"GET"})
     */
    public function showforClass(Classroom $class,PublicationRepository $publicationRepository,$id): Response
    {
      $role=$this->getUser()->getRoles();

      $publicationClass=$publicationRepository->findBy(['classroom' => $id]);
      if($role[0] == "ROLE_TEACHER" || $role[0] == "ROLE_ADMIN"){
        return $this->render('publication/showAll.html.twig', [
            'publications' => $publicationClass,
        ]);
      }
      else {
        return $this->render('publication/showAllEleve.html.twig', [
            'publications' => $publicationClass,
        ]);
      }
    }


    /**
     * @Route("/{id}/edit", name="publication_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Publication $publication): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publication_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Publication $publication): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publication_index');
    }
}
