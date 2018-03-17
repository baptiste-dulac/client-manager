<?php

namespace App\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

interface HasInvoiceItem
{

    public function items(): Collection;

}