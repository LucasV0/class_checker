<?php

namespace App\Form;

use App\Entity\Period;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeriodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Period_Start', DateType::class, [
                'attr' => [
                    'class' => 'form-control some-start',
                    'id' => 'start'
                ],
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Date de début',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('Period_End', DateType::class, [
                'attr' => [
                    'class' => 'form-control some-end',
                    'id' => 'end'
                ],
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Date de fin',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('Session', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de la periode',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('currentPeriod', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input mt-5'
                ]
                ,
                'label' => 'Periode en cours ?',
                'label_attr' => [
                    'class' => 'form-label me-5 mt-5'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-primary mt-4',
                ],
                'label' => 'Valider',
                ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Period::class,
        ]);
    }
}
