<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
     * Objects validation for json
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiPoint(SerializerInterface $serializer, ValidatorInterface $validator)
    {   
        $projects = [];
        
        foreach($this->service->list() as $project){
            if(empty(count($validator->validate($project)))){
                $projects[] = $project;
            }
        
        }
        
        $jsonContent = $serializer->serialize($projects, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
       
        return new Response($jsonContent, 200, ['content-type' => 'json']);
    }
    
    /* Quick solution to return to json
    public function quickJson(): JsonResponse
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
    }*/
    
}