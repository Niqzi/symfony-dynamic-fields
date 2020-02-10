<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    
    public const STATUS = [
        'pending' => 'pending',
        'done' => 'done',
        'failed' => 'failed'
    ];
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * @Assert\Length(max=500)
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", length=20)
     * 
     * @Assert\NotBlank
     */
    private ?string $status = null;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime") 
     * 
     * @Assert\NotBlank
     */
    private ?\DateTime $date = null;
    
    /**
     * @var Project
     * @ORM\ManyToOne (targetEntity="App\Entity\Project", inversedBy="tasks")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * @ORM\OrderBy({"name"="ASC"})
     * 
     * @Assert\NotBlank
     */
    private ?Project $project = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function getDescriptionLimit(int $limit): ?string
    {
        $description = substr($this->description, 0 , $limit);
        return strlen($this->description) > $limit ? "$description..." : $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
