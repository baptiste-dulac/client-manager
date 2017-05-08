<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invoice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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