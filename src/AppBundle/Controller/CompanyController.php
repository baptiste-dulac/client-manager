<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Form\CompanyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CompanyController
 *
 * @package AppBundle\Controller
 * @Route("/companies")
 */
class CompanyController extends Controller
{

    /**
     * @Route("/new", name="app_company_new")
     * @Route("/edit/{id}", name="app_company_edit")
     * @param Request $request
     * @param Company|null $company
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Company $company = null)
    {
        $form = $this->createForm(CompanyType::class, $company);
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                $this->addFlash('success', 'cm.message.new_entity_success');
                return $this->redirectToRoute('app_company_list');
            }
        }
        return $this->render(':company:new.html.twig', [
            'form' => $form->createView(),
            'company' => $company
        ]);
    }

    /**
     * @Route("", name="app_company_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        return $this->render(':company:list.html.twig', [
            'companies' => $this->getDoctrine()->getRepository('AppBundle:Company')->findAll()
        ]);
    }

}