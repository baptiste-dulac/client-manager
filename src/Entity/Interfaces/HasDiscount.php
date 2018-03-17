<?php

namespace App\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

interface HasDiscount
{

    public function discounts(): Collection;

}