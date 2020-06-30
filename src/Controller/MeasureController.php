<?php


namespace App\Controller;
use App\Entity\Classroom;
use App\Entity\Measure;
use App\Entity\School;
use App\Form\MeasureFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MeasureController extends AbstractController
{

    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $schoolRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $classRoomRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $measureRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->schoolRepository = $entityManager->getRepository(School::class);
        $this->classRoomRepository = $entityManager->getRepository(Classroom::class);
        $this->measureRepository = $entityManager->getRepository(Measure::class);
    }


    /**
     * @Route("/posts-measures/{id_classroom}", name="teacher_post_measures",defaults={"id_classroom": 1,})
     *
     * @param Request $request
     *
     * @param int $id_classroom
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function measureForm(Request $request, int $id_classroom){
        $measures = new Measure();
        $form = $this->createForm(MeasureFormType::class, $measures);
        $form->handleRequest($request);

        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {

            $date = new \DateTime();
            $measures->setMeasurementDate($date);
            $classroom= $this->classRoomRepository->findOneById($id_classroom);
            $measures->setClassroom($classroom);

            $this->entityManager->persist($measures);
            $this->entityManager->flush();

            $this->addFlash('success', 'Merci de votre participation');

            return $this->redirectToRoute('show_measures');
        }

        return $this->render('measures/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id_classroom
     * @Route("/measures/{id_classroom}", name="show_measures")
     */
    public function showMeasures(Request $request,$id_classroom){
        $classroom = $this->classRoomRepository->findOneById($id_classroom);
        $measures = $classroom->getMeasures();

        $success = true;
        return $this->render('measures/show.html.twig', [
            'measures' => $measures,
            'success' => $success
        ]);
    }
}