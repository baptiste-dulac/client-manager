<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{

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