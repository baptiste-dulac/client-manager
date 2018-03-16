<?php

namespace App\Entity;

use App\Traits\DatedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cm_invoices")
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Invoice
{

    use DatedTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="code")
     */
    protected $code;

    /**
     * @ORM\Column(name="amount", type="float")
     */
    protected $amount;

    /**
     * @ORM\Column(name="paid", type="boolean")
     */
    protected $paid = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="invoices",cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $project;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InvoiceItem", mappedBy="invoice", cascade={"persist"}, orphanRemoval=true)
     */
    protected $items;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Discount", mappedBy="invoice", cascade={"persist"}, orphanRemoval=true)
     */
    protected $discounts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company")
     */
    protected $company;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->discounts = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf('%s - %s - %s', $this->code, $this->createdAt->format('Y-m-d'), $this->amount);
    }

    public function addItem(InvoiceItem $item): void
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setInvoice($this);
        }
    }

    public function removeItem(InvoiceItem $item): void
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            $item->setInvoice(null);
        }
    }

    public function addDiscount(Discount $discount): void
    {
        if (!$this->discounts->contains($discount)) {
            $this->discounts->add($discount);
            $discount->setInvoice($this);
        }
    }

    public function removeDiscount(Discount $discount): void
    {
        if ($this->discounts->contains($discount)) {
            $this->discounts->removeElement($discount);
            $discount->setInvoice(null);
        }
    }

    public function id()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function code()
    {
        return $this->code;
    }

    public function setCode($code): void
    {
        $this->code = $code;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    public function paid()
    {
        return $this->paid;
    }

    public function setPaid($paid): void
    {
        $this->paid = $paid;
    }

    public function client()
    {
        return $this->client;
    }

    public function setClient($client): void
    {
        $this->client = $client;
    }

    public function project()
    {
        return $this->project;
    }

    public function setProject($project): void
    {
        $this->project = $project;
    }

    public function items()
    {
        return $this->items;
    }

    public function setItems($items): void
    {
        $this->items = $items;
    }

    public function company()
    {
        return $this->company;
    }

    public function setCompany($company): void
    {
        $this->company = $company;
    }

    public function discounts()
    {
        return $this->discounts;
    }

    public function setDiscounts($discounts): void
    {
        $this->discounts = $discounts;
    }

}