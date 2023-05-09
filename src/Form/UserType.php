<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @author LUCAS V
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('date_naissance', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Date de naissance',
                'html5' => true,
                'widget' => 'single_text',
                'label_attr' => [
                    'class' => 'form-label mt-5'

                ]
            ])
            ->add('nom',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('prenom',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('telephone',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Téléphone',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('sexe',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Genre',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
            ])
            ->add('MotDePasse', TextType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control '
                ],
                 'label' => 'Mot de passe',
                'label_attr' => [
                'class' => 'form-label mt-5'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success mt-4'
                ],
                'label' => 'Valider'
            ]);

                
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}







