<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType, TextareaType, DateTimeType};
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Task;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime',
                'required' => false
            ])    
            ->add('status', ChoiceType::class, [
                'choices' => Task::STATUS,
                'expanded' => true,
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class
        ]);
    }
}