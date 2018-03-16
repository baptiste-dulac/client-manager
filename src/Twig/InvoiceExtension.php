<?php

namespace App\Twig;

/**
 * Class InvoiceExtension
 * @package App\Twig
 */
class InvoiceExtension extends \Twig_Extension
{

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('price', [$this, 'priceFilter'])
        ];
    }

    /**
     * @param $price
     * @return string
     */
    public function priceFilter($price)
    {
        return sprintf('%s  €', number_format($price, 2, ',', ' '));
    }

}