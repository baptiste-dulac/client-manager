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
        return $this->render('front/dashboard/index.html.twig', [
            'projects' => $projects->findCurrentProjects(),
            'invoices' => $invoices->findBy([], ['createdAt' => 'DESC'], 10),
            'charts' => [
                'summary' => $charts->summaryChart(),
            ],
            'sum' => [
                'month' => [
                    'paid' => $invoices->findCurrentMonth(true),
                    'not_paid' => $invoices->findCurrentMonth(false),
                ],
                'year' => [
                    'paid' => $invoices->findCurrentYear(true),
                    'not_paid' => $invoices->findCurrentYear(false),
                ],
            ]
        ]);
    }
}
