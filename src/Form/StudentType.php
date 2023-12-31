<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Student;
use App\Entity\ToHave;
use App\Repository\LessonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom',
                'label_attr' => [
                'class' => 'form-label mt-5'
            ],
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Téléphone',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('birthday', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('gender', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Genre',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
                'choices' => ['Homme' => 'Homme', 'Femme' => 'Femme'],
            ])
            ->add('email', EmailType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('level', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    'CAP/BEP' => 'niveau 3',
                    'BAC' => 'niveau 4',
                    'BAC+2' => 'niveau 5',
                    'BAC+3' => 'niveau 6',
                    'BAC+4' => 'niveau 7',
                    'BAC+5' => 'niveau 8',
                ],
                'label' => 'Niveau d\'étude',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success mt-4'
                ],
                'label' => 'Valider'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
