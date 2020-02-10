<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Task[] getQueryListing()
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }
    
     /**
     * Return list of tasks
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQueryListing()
    {
        $qb = $this->createQueryBuilder('t');

        $qb->orderBy('t.project');

        return $qb->getQuery()->getResult();
    }
}
