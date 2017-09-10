<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class InvoiceItem
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="cm_invoice_items")
 */
class InvoiceItem
{

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var float
     * @ORM\Column(name="amount", type="float")
     */
    protected $amount;

    /**
     * @var string
     * @ORM\Column(name="details", type="text")
     */
    protected $details;

    /**
     * @var Invoice
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Invoice", inversedBy="invoices")
     * @ORM\JoinColumn(name="invoice_id", onDelete="SET NULL")
     */
    protected $invoice;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param string $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @param Invoice $invoice
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
    }

}