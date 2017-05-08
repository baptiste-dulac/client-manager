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
        return $this->render(':default:index.html.twig', [
            'projects' => $this->getDoctrine()->getRepository('AppBundle:Project')->findCurrentProjects(),
            'invoices' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findBy([], ['createdAt' => 'DESC'], 10)
        ]);
    }
}
