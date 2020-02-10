<?php

namespace App\Form\DataMapper;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Project;

class ProjectDataMapper implements DataMapperInterface
{
    /**
     * @param Project|null $viewData
     */
    public function mapDataToForms($viewData, $forms)
    {
        if (null === $viewData) {
            return;
        }

        if (!$viewData instanceof Project) {
            throw new UnexpectedTypeException($viewData, Project::class);
        }

        /**
         * @var FormInterface[] $forms
         */
        $forms = iterator_to_array($forms);

        // initialize form field values
        $forms['name']->setData($viewData->getName());
        $forms['description']->setData($viewData->getDescription());
        $forms['tasks']->setData($viewData->getTasks());
    }
    
    public function mapFormsToData($forms, &$viewData)
    {
        /** 
         * @var FormInterface[] $forms 
         */
        $forms = iterator_to_array($forms);
        
        $viewData 
            ->setName($forms['name']->getData())
            ->setDescription($forms['description']->getData());
        
            $ids = [];     
            foreach($forms['tasks']->getData() as $task){
                $ids[] = $task->getId();
                if (!$viewData->getTasks()->contains($task)) {
                    $viewData->addTask($task);
                }
            }
            
            if($viewData->getTasks()->count() !== $forms['tasks']->getData()->count()){
                $viewData->removeTasks($ids);
            }
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {   
        // when creating a new Project, the initial data should be null
        $resolver->setDefault('empty_data', null);
    }
}