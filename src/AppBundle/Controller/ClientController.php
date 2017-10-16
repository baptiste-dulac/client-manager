<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package AppBundle\Controller
 * @Route("/clients")
 */
class ClientController extends Controller
{

    /**
     * @Route("/new", name="app_client_new")
     * @Route("/edit/{id}", name="app_client_edit")
     * @param Request $request
     * @param Client|null $client
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Client $client = null)
    {
        $form = $this->createForm(ClientType::class, $client);
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                /** @var Client $client */
                $client = $form->getData();

                if (!$client->getUser())
                    $client->setUser($this->getUser());

                $em->persist($client);
                $em->flush();

                $this->addFlash('success', 'cm.message.new_entity_success');
                return $this->redirectToRoute('app_client_list');
            }
        }
        return $this->render(':client:new.html.twig', [
            'form' => $form->createView(),
            'client' => $client
        ]);
    }

    /**
     * @Route("", name="app_client_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        return $this->render(':client:list.html.twig', [
            'clients' => $this->getDoctrine()->getRepository('AppBundle:Client')->findBy([], ['createdAt' => 'DESC'])
        ]);
    }

}