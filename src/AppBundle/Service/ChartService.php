<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class ChartService
 * @package AppBundle\Service
 */
class ChartService
{

    private $em;

    /**
     * ChartService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param $results
     * @return array
     */
    private function formatResults($results)
    {
        $data = [];
        foreach ($results as $r)
            $data[$r['month']] = $r['amount'];
        return $data;
    }

    /**
     * @return array
     */
    public function summaryChart()
    {
        $labels = [];
        $series = [
            0 => [],
            1 => [],
        ];
        $history = 12;
        $from = \DateTime::createFromFormat('U', mktime(null, null, null, date('m') - 12));
        $invoicePaid = $this->formatResults($this->em->getRepository('AppBundle:Invoice')->findAmountGroupedByMonth($from, true));
        $invoiceNotPaid = $this->formatResults($this->em->getRepository('AppBundle:Invoice')->findAmountGroupedByMonth($from, false));

        for ($i = $history; $i >= 0; --$i)
        {
            $time = mktime(null, null, null, date('m') - $i);
            $key = date('n-Y', $time);
            $labels[] = date('M', $time);
            $series[0][] = !empty($invoicePaid[$key]) ? $invoicePaid[$key] : 0;
            $series[1][] = !empty($invoiceNotPaid[$key]) ? $invoiceNotPaid[$key] : 0;
        }

        return [
            'labels' => $labels,
            'series' => $series
        ];
    }

}