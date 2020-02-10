<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response, JsonResponse};
use App\Entity\Project;
use App\Manager\Admin\Project as ProjectManager;

class ProjectController extends AbstractController
{
    private ProjectManager $service;
    
    public function __construct(ProjectManager $manager) 
    {
        $this->service = $manager;
    }
    
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('admin/project/index.html.twig', [
            'projects' => $this->service->list()
        ]);
    }   
    
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        return $this->manageForm($request, new Project());
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, Project $project)
    {  
        return $this->manageForm($request, $project);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function manageForm(Request $request, Project $project)
    {   
        $form = $this->service->manageForm($request, $project);

        if (true === $form) {
            return $this->redirectToRoute('admin_project_list');
        }

        return $this->render('admin/project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Project $project)
    {
        $this->service->delete($project);

        return $this->redirectToRoute('admin_project_list');
    }
    
    /**
     * @return JsonResponse
     */
    public function apiPoint()
    {
        $data = [];
        $projects = $this->service->list();
        foreach($projects as $project){
            $data[] = [
                'id' => $project->getId(),
                'name' => $project->getName(),
                'description' => $project->getDescription()
            ]; 
        }
        
        return new JsonResponse(['projects' => $data]);
    }
    
}