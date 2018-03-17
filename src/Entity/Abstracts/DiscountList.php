<?php

namespace App\Entity\Abstracts;

use App\Entity\Interfaces\HasDiscount;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

abstract class DiscountList extends InvoiceItemList implements HasDiscount
{

    /**
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="App\Entity\Discount", mappedBy="invoice", cascade={"persist"}, orphanRemoval=true)
     */
    protected $discounts;

    public function discounts(): Collection
    {
        return $this->discounts;
    }

    public function setDiscounts($discounts): void
    {
        $this->discounts = $discounts;
    }

}
