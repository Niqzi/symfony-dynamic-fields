<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Project[] getQueryListing()
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }
    
    /**
     * Return list of projects
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQueryListing()
    {
        $qb = $this->createQueryBuilder('p');

        $qb->orderBy('p.name');

        return $qb->getQuery()->getResult();
    }
    
}
