<?php

namespace App\Controller\Admin;

use App\Repository\InvoiceRepository;
use App\Repository\ProjectRepository;
use App\Service\ChartService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class DashboardController extends AdminController
{
    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function dashboardAction(
        ChartService $charts,
        ProjectRepository $projects,
        InvoiceRepository $invoices
    )
    {
        $curYear = date('Y');
        $prvYear = date('Y') - 1;

        return $this->render('front/dashboard/index.html.twig', [
            'projects' => $projects->findCurrentProjects(),
            'invoices' => $invoices->findBy([], ['createdAt' => 'DESC'], 10),
            'charts' => [
                'summary' => $charts->summaryChart(),
            ],
            'sum' => [
                'month' => [
                    'paid' => $invoices->findTotalForCurrentMonth(true),
                    'not_paid' => $invoices->findTotalForCurrentMonth(false),
                ],
                'year' => [
                    'paid' => $invoices->findTotalForCurrentYear(true),
                    'not_paid' => $invoices->findTotalForCurrentYear(false),
                    'q1' => [
                        'paid' => $invoices->findTotalForMonths(['1-'.$curYear, '2-'.$curYear, '3-'.$curYear], true),
                        'not_paid' =>$invoices->findTotalForMonths(['1-'.$curYear, '2-'.$curYear, '3-'.$curYear], false),
                    ],
                    'q2' => [
                        'paid' => $invoices->findTotalForMonths(['4-'.$curYear, '5-'.$curYear, '6-'.$curYear], true),
                        'not_paid' =>$invoices->findTotalForMonths(['4-'.$curYear, '5-'.$curYear, '6-'.$curYear], false),
                    ],
                    'q3' => [
                        'paid' => $invoices->findTotalForMonths(['7-'.$curYear, '8-'.$curYear, '9-'.$curYear], true),
                        'not_paid' =>$invoices->findTotalForMonths(['7-'.$curYear, '8-'.$curYear, '9-'.$curYear], false),
                    ],
                    'q4' => [
                        'paid' => $invoices->findTotalForMonths(['10-'.$curYear, '11-'.$curYear, '12-'.$curYear], true),
                        'not_paid' =>$invoices->findTotalForMonths(['10-'.$curYear, '11-'.$curYear, '12-'.$curYear], false),
                    ],
                ],
                'prv_year' => [
                    'paid' => $invoices->findTotalForYear(date('Y') - 1, true),
                    'not_paid' => $invoices->findTotalForYear(date('Y') - 1, false),
                    'q1' => [
                        'paid' => $invoices->findTotalForMonths(['1-'.$prvYear, '2-'.$prvYear, '3-'.$prvYear], true),
                        'not_paid' =>$invoices->findTotalForMonths(['1-'.$prvYear, '2-'.$prvYear, '3-'.$prvYear], false),
                    ],
                    'q2' => [
                        'paid' => $invoices->findTotalForMonths(['4-'.$prvYear, '5-'.$prvYear, '6-'.$prvYear], true),
                        'not_paid' =>$invoices->findTotalForMonths(['4-'.$prvYear, '5-'.$prvYear, '6-'.$prvYear], false),
                    ],
                    'q3' => [
                        'paid' => $invoices->findTotalForMonths(['7-'.$prvYear, '8-'.$prvYear, '9-'.$prvYear], true),
                        'not_paid' =>$invoices->findTotalForMonths(['7-'.$prvYear, '8-'.$prvYear, '9-'.$prvYear], false),
                    ],
                    'q4' => [
                        'paid' => $invoices->findTotalForMonths(['10-'.$prvYear, '11-'.$prvYear, '12-'.$prvYear], true),
                        'not_paid' =>$invoices->findTotalForMonths(['10-'.$prvYear, '11-'.$prvYear, '12-'.$prvYear], false),
                    ],
                ],
            ]
        ]);
    }
}
