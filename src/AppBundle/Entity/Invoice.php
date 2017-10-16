<?php

namespace AppBundle\Entity;

use AppBundle\Traits\DatedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Invoice
 * @package AppBundle\Entity
 * @ORM\Table(name="cm_invoices")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvoiceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Invoice
{

    use DatedTrait;

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
     * @var boolean
     * @ORM\Column(name="paid", type="boolean")
     */
    protected $paid = false;

    /**
     * @var Client
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $client;

    /**
     * @var Project
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="invoices",cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $project;

    /**
     * @var string
     * @ORM\Column(name="details", type="text")
     */
    protected $details;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\InvoiceItem", mappedBy="invoice", cascade={"persist"})
     */
    protected $invoiceItems;

    public function __construct()
    {
        $this->invoiceItems = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return sprintf('F-DULAC-%s-%03d', $this->createdAt->format('Ym'), $this->getId());
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @param bool $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
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
     * @return ArrayCollection
     */
    public function getInvoiceItems()
    {
        return $this->invoiceItems;
    }

    /**
     * @param ArrayCollection $invoiceItems
     */
    public function setInvoiceItems($invoiceItems)
    {
        $this->invoiceItems = $invoiceItems;
    }

    /**
     * @param InvoiceItem $invoiceItem
     */
    public function addInvoiceItem(InvoiceItem $invoiceItem)
    {
        if (!$this->invoiceItems->contains($invoiceItem))
        {
            $this->invoiceItems->add($invoiceItem);
            $invoiceItem->setInvoice($this);
        }
    }

    /**
     * @param InvoiceItem $invoiceItem
     */
    public function removeInvoiceItem(InvoiceItem $invoiceItem)
    {
        if ($this->invoiceItems->contains($invoiceItem))
        {
            $this->invoiceItems->removeElement($invoiceItem);
            $invoiceItem->setInvoice(null);
        }
    }
}