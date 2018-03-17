<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cm_discounts")
 */
class Discount
{

    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="amount", type="float")
     */
    protected $amount;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="details", type="text")
     */
    protected $details;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Invoice", inversedBy="discounts")
     * @ORM\JoinColumn(name="invoice_id", onDelete="SET NULL")
     */
    protected $invoice;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="quantity", type="integer")
     */
    protected $quantity;

    public function __toString()
    {
        return sprintf('%s - %s', substr($this->details, 0, 50), $this->amount);
    }

    public function total()
    {
        return $this->amount * $this->quantity;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    public function details()
    {
        return $this->details;
    }

    public function setDetails($details): void
    {
        $this->details = $details;
    }

    public function invoice()
    {
        return $this->invoice;
    }

    public function setInvoice($invoice): void
    {
        $this->invoice = $invoice;
    }

    public function id()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function quantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

}