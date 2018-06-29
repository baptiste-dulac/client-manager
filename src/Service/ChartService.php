<?php

namespace App\Service;

use App\Repository\InvoiceRepository;

class ChartService
{

    private $invoices;

    public function __construct(InvoiceRepository $invoices)
    {
        $this->invoices = $invoices;
    }

    private function formatResults($results): array
    {
        $data = [];
        foreach ($results as $r)
            $data[$r['month']] = $r['amount'];
        return $data;
    }

    public function summaryChart(): array
    {
        $labels = [];
        $series = [
            0 => [],
            1 => [],
        ];
        $history = 12;
        $from = \DateTime::createFromFormat('U', mktime(null, null, null, date('m') - 12));
        $invoicePaid = $this->formatResults($this->invoices->findAmountGroupedByMonth($from, true));
        $invoiceNotPaid = $this->formatResults($this->invoices->findAmountGroupedByMonth($from, false));

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