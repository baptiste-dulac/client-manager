<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invoice;
use AppBundle\Form\InvoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InvoiceController
 * @package AppBundle\Controller
 * @Route("/invoices")
 */
class InvoiceController extends Controller
{

    /**
     * @Route("", name="app_invoice_list")
     */
    public function listAction()
    {
        return $this->render(':invoice:list.html.twig', [
           'invoices' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    /**
     * @Route("/add", name="app_invoice_add")
     * @Route("/{id}", name="app_invoice_edit", requirements={"id": "\d+"})
     * @param Request $request
     * @param Invoice|null $invoice
     * @return Response
     */
    public function addAction(Request $request, Invoice $invoice = null)
    {
        $form = $this->createForm(InvoiceType::class, $invoice);
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                return $this->redirectToRoute('app_invoice_list');
            }
        }

        return $this->render(':invoice:add.html.twig', [
            'invoice' => $invoice,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/download/{id}", name="app_invoice_download")
     * @param Invoice $invoice
     * @return Response
     */
    public function downloadAction(Invoice $invoice)
    {
        $html = $this->renderView(':pdf:invoice.html.twig', array(
            'invoice'  => $invoice
        ));

        $footer = $this->renderView(':pdf:_footer.html.twig');

        $header = $this->renderView(':pdf:_header.html.twig', array(
            'date' => $invoice->getCreatedAt()->format('d/m/Y'),
            'title' => $invoice->getCode()
        ));

        $snappy = $this->get('knp_snappy.pdf');
        $snappy->setOption('footer-html', $footer);
        $snappy->setOption('header-html', $header);

        $filename = sprintf('%s_%s.pdf', $invoice->getCode(), $invoice->getClient()->getName());

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => sprintf('attachment; filename="%s"', $filename)
            )
        );

    }


}