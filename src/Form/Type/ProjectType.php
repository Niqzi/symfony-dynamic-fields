<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{CollectionType, SubmitType, TextType, TextareaType};
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Project;
use App\Form\DataMapper\ProjectDataMapper;

class ProjectType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setDataMapper(new ProjectDataMapper());
        $builder
            ->add('name', TextType::class, [
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('save', SubmitType::class)
            ->add('tasks', CollectionType::class, [
                'entry_type' => TaskType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'label' => false,
                'required' => false
        ]);  
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class
        ]);
    }
}
