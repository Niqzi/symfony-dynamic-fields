<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * @Assert\Length(max=500)
     */
    private ?string $description = null;
    
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="project", cascade={"persist", "remove"})
     * @ORM\OrderBy({"description"="ASC"})
     * 
     * @Assert\Valid
     * @Assert\NotBlank
     */
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setProject($this);
        }
       
        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }

        return $this;
    }
    
    public function removeTasks(array $ids): void
    {
        foreach($this->tasks as $task){
            if(!in_array($task->getId(), $ids)){
                $this->removeTask($task);
            }
        }
    }    
}
