<?php

namespace App\Entity\Abstracts;

use App\Entity\Interfaces\HasInvoiceItem;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

abstract class InvoiceItemList implements HasInvoiceItem
{

    /**
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="App\Entity\InvoiceItem", mappedBy="invoice", cascade={"persist"}, orphanRemoval=true)
     */
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