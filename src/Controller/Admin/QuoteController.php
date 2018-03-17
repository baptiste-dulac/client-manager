<?php

namespace App\Controller\Admin;

use App\Entity\Quote;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InvoiceController
 * @package App\Controller
 * @Route("/admin")
 */
class QuoteController extends AdminController
{

    /**
     * @Route("/quotes/download/{id}", name="quote_download")
     */
    public function downloadAction(Quote $quote, Pdf $knp)
    {
        $html = $this->renderView('pdf/quote.html.twig', array(
            'quote' => $quote
        ));

        $footer = $this->renderView('pdf/_footer.html.twig');

        $header = $this->renderView('pdf/_header.html.twig', array(
            'date' => $quote->createdAt()->format('d/m/Y'),
            'title' => $quote->code()
        ));

        $knp->setOption('footer-html', $footer);
        $knp->setOption('header-html', $header);

        $filename = sprintf('%s_%s.pdf', $quote->code(), $quote->client()->name());

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