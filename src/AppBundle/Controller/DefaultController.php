<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $charts = $this->get('cm.chart_service');
        return $this->render(':default:index.html.twig', [
            'projects' => $this->getDoctrine()->getRepository('AppBundle:Project')->findCurrentProjects(),
            'invoices' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findBy([], ['createdAt' => 'DESC'], 10),
            'charts' => [
                'summary' => $charts->summaryChart(),
            ],
            'sum' => [
                'month' => [
                    'paid' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findCurrentMonth(true),
                    'not_paid' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findCurrentMonth(false),
                ],
                'year' => [
                    'paid' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findCurrentYear(true),
                    'not_paid' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findCurrentYear(false),
                ],
            ]
        ]);
    }
}
