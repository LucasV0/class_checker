<?php

namespace App\Form;

use App\Entity\ToHave;
use App\Entity\Lesson;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToHaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('students',
            EntityType::class,[
                'class' => Student::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                ]
            )
            ->add('Lessons', EntityType::class, [
                'class' => Lesson::class,
                'choice_label' => 'label',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ToHave::class,
        ]);
    }
}
