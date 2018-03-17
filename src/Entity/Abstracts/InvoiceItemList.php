<?php

namespace App\Entity\Abstracts;

use App\Entity\Interfaces\HasInvoiceItem;
use Doctrine\Common\Collections\Collection;

abstract class InvoiceItemList implements HasInvoiceItem
{

    protected $items;

    public function items(): Collection
    {
        return $this->items;
    }

    public function setItems($items): void
    {
        $this->items = $items;
    }

}