<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    /**
     * @Route("/teacher/new_publication", name="new_publication")
     */
    public function index()
    {
        return $this->render('teacher/new_publication.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }
}
