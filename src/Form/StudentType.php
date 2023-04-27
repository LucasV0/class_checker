<?php

namespace App\Form;

use App\Entity\Student;
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
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Prenom',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Numéro de telephone',
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
                'label' => 'Sexe',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
                'choices' => ['Masculin' => 'Masculin', 'Feminin' => 'Feminin', 'Non binaire' => 'Non binaire'],
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
            ->add('level', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Niveau d\'étude',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
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
