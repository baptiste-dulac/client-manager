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

    public function findTotalGroupedByMonth(\DateTime $from, $paid = true)
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

    public function findTotalForMonths(array $months, $paid = true) {
        return $this
                   ->createQueryBuilder('o')
                   ->select('SUM(o.amount)')
                   ->where('CONCAT(MONTH(o.createdAt), \'-\', YEAR(o.createdAt)) IN (:months)')
                   ->andWhere('o.paid = :paid')
                   ->setParameter('months', $months)
                   ->setParameter('paid', $paid)
                   ->getQuery()
                   ->getSingleScalarResult()
               ?? 0 ;
    }

    public function findTotalForMonth(string $month, string $year, $paid = true): int
    {
        return $this
                   ->createQueryBuilder('o')
                   ->select('SUM(o.amount)')
                   ->where('CONCAT(MONTH(o.createdAt), \'-\', YEAR(o.createdAt)) = :date')
                   ->andWhere('o.paid = :paid')
                   ->setParameter('date', sprintf('%s-%s', $month, $year))
                   ->setParameter('paid', $paid)
                   ->getQuery()
                   ->getSingleScalarResult()
               ?? 0 ;
    }

    public function findTotalForCurrentMonth($paid = true): int
    {
        return $this->findTotalForMonth(date('n'), date('Y'), $paid);
    }

    public function findTotalForYear(string $year, $paid = true): int {
        return $this
                   ->createQueryBuilder('o')
                   ->select('SUM(o.amount)')
                   ->where('YEAR(o.createdAt) = :year')
                   ->andWhere('o.paid = :paid')
                   ->setParameter('year', $year)
                   ->setParameter('paid', $paid)
                   ->getQuery()
                   ->getSingleScalarResult()
               ?? 0 ;
    }

    public function findTotalForCurrentYear($paid = true): int
    {
        return $this->findTotalForYear(date('Y'), $paid);
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
