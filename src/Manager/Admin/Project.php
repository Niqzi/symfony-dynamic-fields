<?php

namespace App\Manager\Admin;

use App\Form\Type\ProjectType;
use App\Manager\Partial\FlashbagTrait;
use App\Manager\Partial\FormTrait;
use App\Repository\ProjectRepository;
use App\Entity\Project as ProjectEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class Project
{
    use FlashbagTrait, FormTrait;

    private EntityManagerInterface $entity_manager;

    private ProjectRepository $project_repository;

    public function __construct(EntityManagerInterface $entity_manager, ProjectRepository $project_repository)
    {
        $this->entity_manager = $entity_manager;
        $this->project_repository = $project_repository;
    }
    
    public function list(): array
    {    
        return $this->project_repository->getQueryListing();
    }        
    
    /**
     * @return bool|\Symfony\Component\Form\FormInterface
     */
    public function manageForm(Request $request, ProjectEntity $project)
    {
        $form = $this->createForm(ProjectType::class, $project, []);

        $form->handleRequest($request);

        if (true === $form->isSubmitted() && true === $form->isValid()) {
            $is_new = null === $project->getId();

            $this->entity_manager->persist($project);
            $this->entity_manager->flush();
            if (true === $is_new) {
                $this->addFlash('success', 'project.added', ['%project%' => $project->getName()]);
            } else {
                $this->addFlash('success', 'project.edited', ['%project%' => $project->getName()]);
            }

            return true;
        }

        return $form;
    }

    public function delete(ProjectEntity $project): void
    {
        $this->entity_manager->remove($project);
        $this->entity_manager->flush();

        $this->addFlash('success', 'project.deleted', ['%project%' => $project->getName()]);
    }
    
}
