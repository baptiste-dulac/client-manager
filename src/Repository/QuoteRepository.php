<?php

namespace App\Repository;

use App\Entity\Quote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class QuoteRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    public function existsWithCodeEndingBy(string $endBy): bool
    {
        return intval($this
                ->createQueryBuilder('o')
                ->select('COUNT(o.id)')
                ->where('o.code LIKE :code')
                ->setParameter('code', $endBy)
                ->getQuery()
                ->getSingleScalarResult())
               !== 0
            ;
    }

}