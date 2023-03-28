<?php

namespace App\Form;

use App\Entity\Lesson;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Label', TextType::class,[
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Nom',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\NotNull()
                    ]
                ]
            )
            ->add('Number_Max_Of_Students',
            TextType::class, [
        'attr' => [
            'class' => 'form-control'
        ],
        'label' => "Nombre Maximum d'élève",
        'label_attr' => [
            'class' => 'form-label mt-4'
        ],
        'constraints' => [
            new Assert\NotBlank(),
            new Assert\NotNull()
        ]
            ])
            ->add('Time_Start',DateType::class, [
        'attr' => [

        ],
        'widget' => 'single_text',
        'html5'=>true,
        'label' => 'Date de début ',
        'label_attr' => [
            'class' => 'date_format mt-5 pt-3'
        ],
        'constraints' => [
            new Assert\NotBlank(),
            new Assert\NotNull()
        ]
    ])
            ->add('Time_End',DateType::class, [
                'attr' => [

                ],
                'widget' => 'single_text',
                'html5'=>true,
                'label' => 'Date de fin ',
                'label_attr' => [
                    'class' => 'date_format mt-5 pt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
            ->add('Hours_Start',TimeType::class, [
                'attr' => [

                ],
                'input' => 'timestamp',
                'widget' => 'choice',
                'html5'=>true,
                'label' => 'heure de début ',
                'label_attr' => [
                    'class' => 'date_format mt-5 pt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
            ->add('Hours_End',TimeType::class, [
                'attr' => [

                ],
                'input' => 'timestamp',
                'widget' => 'choice',
                'html5'=>true,
                'label' => 'heure de fin ',
                'label_attr' => [
                    'class' => 'date_format mt-5 pt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
            ->add('Day', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => "Nombre Maximum d'élève",
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
