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
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom'
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Prenom'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de telephone'
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Date de naissance',
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => ['Masculin' => 'Masculin', 'Feminin' => 'Feminin', 'Non binaire' => 'Non binaire'],
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email'
            ])
            ->add('level', TextType::class, [
                'label' => 'Niveau d\'étude'
            ])
            ->add('submit', SubmitType::class, [
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
