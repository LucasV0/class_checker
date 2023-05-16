<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
                    'class' => 'form-label mt-1'
                ],
            ])
            ->add('prenom',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label mt-1'
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
            ->add('sexe',ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Sexe',
                'label_attr' => [
                    'class' => 'form-label mt-5'
                ],
                'choices' => ['Homme' => 'Homme', 'Femme' => 'Femme']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  =>
                    ['attr' => [
                    'class' => 'form-control '
                ],
                        'label' => 'Mot de passe',
                        'hash_property_path' => 'password',
                        'label_attr' => [
                            'class' => 'form-label mt-5'
                        ],
                    ],
                'second_options' =>
                    [
                        'attr' => [
                            'class' => 'form-control '
                        ],
                        'label' => 'Repeter mot de passe',
                        'label_attr' => [
                            'class' => 'form-label mt-5'
                        ],

                    ],
                'mapped' => false,
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







