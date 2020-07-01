<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\File;
use App\Entity\Measure;
use App\Entity\Publication;
use App\Form\MeasureFormType;
use App\Repository\ClassRoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{


    private $formE;

    /**
     * @Route("/teacher/new_publication", name="new_publication")
     */
    public function add_publication(Request $request, EntityManagerInterface $entityManagerInterface)
    {

        $publication = new Publication();
        $form = $this->createFormBuilder($publication)
            ->add("title", TextType::class)
            ->add("content", TextareaType::class)
            ->add("files", FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add("classroom", EntityType::class, [
                'class' => Classroom::class,
                'choices' => $this->getUser()->getClassroom(),
                'mapped' => false,
                'choice_label' => 'name'
            ])
            ->add("measure", MeasureFormType::class)
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $formEvent) {

                $this->formE =  $formEvent->getForm();

                $classroom = $this->formE->get("classroom")->getData();

                $clr = $this->getDoctrine()->getRepository(Classroom::class)->find($classroom);
                $this->formE->getData()->setClassroom($clr);
                $this->formE->getData()->setDate(new \DateTime());

            })
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $filesystem = new Filesystem();
            $publicationCreated = $form->getData();


            $files = $form['files']->getData();

            if(count($files) > 0){
                foreach ($files as $file) {
                    $extension = $file->guessExtension();
                    $newNameFile = $publicationCreated->getTitle() . '-' . uniqid() . '.' . $extension;
                    $fileSize = $file->getClientSize();
                    $file->move($this->getParameter('uploads'), $newNameFile);
                    $filer = new File();
                    $filer->setName($newNameFile);
                    $filer->setMimeType($extension);
                    $filer->setFileSize($fileSize);
                    $entityManagerInterface->persist($filer);
                    $publicationCreated->addFile($filer);
                }
            }else{

            }

            $entityManagerInterface->persist($publicationCreated);
            $entityManagerInterface->flush();
        }


        return $this->render('teacher/new_publication.html.twig', [
            'controller_name' => 'TeacherController',
            'form' => $form->createView()
        ]);
    }
}
