<?php

namespace App\Controller\Admin;

use App\Entity\Invoice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InvoiceController
 * @package App\Controller
 * @Route("/admin")
 */
class InvoiceController extends AdminController
{

    /**
     * @Route("/invoices/download/{id}", name="invoice_download")
     */
    public function downloadAction(Invoice $invoice, Pdf $knp)
    {
        $html = $this->renderView('pdf/invoice.html.twig', array(
            'invoice'  => $invoice
        ));

        $footer = $this->renderView('pdf/_footer.html.twig');

        $header = $this->renderView('pdf/_header.html.twig', array(
            'date' => $invoice->createdAt()->format('d/m/Y'),
            'title' => $invoice->code()
        ));

        $knp->setOption('footer-html', $footer);
        $knp->setOption('header-html', $header);

        $knp->setTimeout(300);

        $filename = sprintf('%s_%s.pdf', $invoice->code(), $invoice->client()->name());

        return new Response(
            $knp->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => sprintf('attachment; filename="%s"', $filename)
            )
        );

    }


}