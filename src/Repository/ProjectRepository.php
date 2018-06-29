<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ProjectRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @return array
     */
    public function findCurrentProjects()
    {
        return $this
            ->createQueryBuilder('o')
            ->where('o.startsAt < :date AND o.endsAt > :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('o.endsAt', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}