<?php


namespace App\Controller;

use App\Entity\School;
use App\Entity\Classroom;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClassRoomController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $schoolRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $classRoomRepository;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->schoolRepository = $entityManager->getRepository(School::class);
        $this->classRoomRepository = $entityManager->getRepository(Classroom::class);
    }
    /**
     * @Route("/classroom/{id}", name="classroom_id")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function classroom(Request $request, $id){

        $classroom = $this->classRoomRepository->find($id);
    }
}