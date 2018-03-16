<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cm_invoice_items")
 */
class InvoiceItem
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="amount", type="float")
     */
    protected $amount;

    /**
     * @ORM\Column(name="details", type="text")
     */
    protected $details;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Invoice", inversedBy="items")
     * @ORM\JoinColumn(name="invoice_id", onDelete="SET NULL")
     */
    protected $invoice;

    public function __toString()
    {
        return sprintf('%s - %s', substr($this->details, 0, 50), $this->amount);
    }

    public function id()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
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

}