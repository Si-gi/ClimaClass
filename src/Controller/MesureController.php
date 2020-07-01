<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MesureController extends AbstractController
{
    /**
     * @Route("/mesure", name="mesure")
     */
    public function index()
    {
        return $this->render('mesure/index.html.twig', [
            'controller_name' => 'MesureController',
        ]);
    }
}
