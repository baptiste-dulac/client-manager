<?php

namespace App\Entity;

use App\Entity\Abstracts\InvoiceItemList;
use App\Entity\Interfaces\HasAmount;
use App\EventListener\QuoteAcceptedListener;
use App\Traits\DatedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cm_quote")
 * @ORM\HasLifecycleCallbacks()
 */
class Quote extends InvoiceItemList implements HasAmount
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
    protected $accepted = false;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $client;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="quotes", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $project;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\Company")
     */
    protected $company;

    /**
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="App\Entity\InvoiceItem", mappedBy="quote", cascade={"persist"}, orphanRemoval=true)
     */
    protected $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf('%s - %s - %s', $this->code, $this->createdAt->format('Y-m-d'), $this->amount);
    }

    public function addItem(InvoiceItem $item): void
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setQuote($this);
        }
    }

    public function removeItem(InvoiceItem $item): void
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            $item->setQuote(null);
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

    public function client()
    {
        return $this->client;
    }

    public function setClient($client): void
    {
        $this->client = $client;
    }

    public function project(): ?Project
    {
        return $this->project;
    }

    public function setProject($project): void
    {
        $this->project = $project;
    }

    public function company()
    {
        return $this->company;
    }

    public function setCompany($company): void
    {
        $this->company = $company;
    }

    public function setAccepted($accepted): void
    {
        if ($accepted !== $this->accepted) {
            $this->addPropertyChangedListener(new QuoteAcceptedListener());
            $this->onPropertyChanged('accepted', $this->accepted, $accepted);
            $this->accepted = $accepted;
        }
    }

    public function accepted()
    {
        return $this->accepted;
    }

}
