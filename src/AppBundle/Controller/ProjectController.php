<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectController
 * @package AppBundle\Controller
 * @Route("/projects")
 */
class ProjectController extends Controller
{

    /**
     * @Route("/add", name="app_project_add")
     * @Route("/{id}", name="app_project_edit", requirements={"id" : "\d+"})
     * @param Request $request
     * @param Project|null $project
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, Project $project = null)
    {
        $form = $this->createForm(ProjectType::class, $project);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                return $this->redirectToRoute('app_project_list');
            }
        }

        return $this->render(':project:add.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    /**
     * @Route("", name="app_project_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render(':project:list.html.twig', [
            'projects' => $this->getDoctrine()->getRepository('AppBundle:Project')->findAll(),
        ]);
    }

}