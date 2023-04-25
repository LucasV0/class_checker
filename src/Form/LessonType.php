<?php

namespace App\Form;

use App\Entity\Lesson;

use App\Entity\Period;
use App\Repository\PeriodRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Baptiste Caron
 */

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextareaType::class, [
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
            ->add('number_Max_Of_Students',
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
            ->add('time_Start', DateType::class, [
                'attr' => [
                    'class' => 'some-start form-control',
                    'id' => 'start'
                ],
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Date de début ',
                'label_attr' => [
                    'class' => 'date_format mt-5 pt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
            ->add('period', EntityType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                "class" => Period::class,
                "query_builder" => function(PeriodRepository $j){
                    return $j -> createQueryBuilder('j');
                },
                "choice_label" => "session",
                'label' => 'Periode',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('time_End', DateType::class, [
                'attr' => [
                    'class' => 'some-end form-control',
                ],
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Date de fin',
                'label_attr' => [
                    'class' => 'date_format mt-5 pt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
            ->add('hours_Start', TimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'input' => 'datetime',
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'heure de début ',
                'label_attr' => [
                    'class' => 'date_format mt-3 pt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
            ->add('hours_End', TimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'input' => 'datetime',
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'heure de fin ',
                'label_attr' => [
                    'class' => 'date_format mt-3 pt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
            ->add('day', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices'  => [
                    'Choisir un jour' => null,
                    'Lundi' => '1',
                    'Mardi' => '2',
                    'Mercredi' => '3',
                    'Jeudi' => '4',
                    'Vendredi' => '5',
                    'Samedi' => '6',
                ],
                'label' => "Jour de la semaine",
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-primary mt-4'
                ],
                'label' => 'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
