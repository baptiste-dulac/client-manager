<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class InvoiceRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

    public function findAmountGroupedByMonth(\DateTime $from, $paid = true)
    {
        return $this
            ->createQueryBuilder('o')
            ->select('CONCAT(MONTH(o.createdAt), \'-\', YEAR(o.createdAt)) as month, SUM(o.amount) as amount')
            ->where('o.createdAt > :from')
            ->andWhere('o.paid = :paid')
            ->groupBy('month')
            ->setParameter('from', $from)
            ->setParameter('paid', $paid)
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function findCurrentMonth($paid = true)
    {
        return $this
            ->createQueryBuilder('o')
            ->select('SUM(o.amount)')
            ->where('CONCAT(MONTH(o.createdAt), \'-\', YEAR(o.createdAt)) = :month')
            ->andWhere('o.paid = :paid')
            ->setParameter('month', date('n-Y'))
            ->setParameter('paid', $paid)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findCurrentYear($paid = true)
    {
        return $this
            ->createQueryBuilder('o')
            ->select('SUM(o.amount)')
            ->where('YEAR(o.createdAt) = :month')
            ->andWhere('o.paid = :paid')
            ->setParameter('month', date('Y'))
            ->setParameter('paid', $paid)
            ->getQuery()
            ->getSingleScalarResult()
            ;
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
