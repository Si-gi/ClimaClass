<?php

namespace App\Form;

use App\Repository\ClassRoomRepository;
use App\Repository\UserRepository;
use App\Entity\PublicMessage;
use App\Entity\Classroom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PublicMessageType extends AbstractType
{
    private $classRoomRepository;
    public function __construct(ClassRoomRepository $classRoomRepository)
    {
        $this->classRoomRepository = $classRoomRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', TextareaType::class,  [
            'attr' => ['class' => 'form-control', 'rows'=>"3"],
        ])
            ->add('sender', EntityType::class,
            ['class' => Classroom::class,
                'choices' => $options['classroom']
                ]
            )
            ->add('submit', SubmitType::class,
                [
                    'attr' => ['class' => 'form-control btn-primary pull-right'],
                    'label' => 'Create!'
                ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublicMessage::class,
            'classroom' => array()
        ]);
    }
}
