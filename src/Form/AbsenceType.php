<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Absence;
use App\Entity\Justify;
use App\Repository\JustifyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        

 
        

            ->add('justify', EntityType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width:30em'
                ],
                "class" => Justify::class,
                "query_builder" => function(JustifyRepository $j){
                    return $j -> createQueryBuilder('j');
                },
                "choice_label" => "description",
                'label' => 'Justification :',
                'label_attr' => [
                    'class' => 'form-label mt-3 text-dark'
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
            'data_class' => Absence::class,
        ]);
    }
}

