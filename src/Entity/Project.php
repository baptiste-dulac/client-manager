<?php

namespace App\Entity;

use App\Traits\DatedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Project
 * @ORM\Table(name="cm_projects", indexes={
 *     @Index(name="DATES_IDX", columns={"starts_at", "ends_at"})
 *     })
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Project
{

    use DatedTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="name")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="projects", cascade={"persist"})
     */
    protected $client;

    /**
     * @ORM\Column(name="starts_at", type="datetime", nullable=true)
     */
    protected $startsAt;

    /**
     * @ORM\Column(name="ends_at", type="datetime", nullable=true)
     */
    protected $endsAt;

    /**
     * @ORM\Column(name="budget", type="float")
     */
    protected $budget = 0;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Invoice",
     *     mappedBy="project",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    protected $invoices;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Quote",
     *     mappedBy="project",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    protected $quotes;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->quotes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function code()
    {
        return sprintf('P-%03d', $this->id);
    }

    public function id()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function name()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function client()
    {
        return $this->client;
    }

    public function setClient($client): void
    {
        $this->client = $client;
    }

    public function startsAt()
    {
        return $this->startsAt;
    }

    public function setStartsAt($startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function endsAt()
    {
        return $this->endsAt;
    }

    public function setEndsAt($endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    public function budget()
    {
        return $this->budget;
    }

    public function setBudget($budget): void
    {
        $this->budget = $budget;
    }

    public function invoices()
    {
        return $this->invoices;
    }

    public function setInvoices($invoices): void
    {
        $this->invoices = $invoices;
    }

    public function quotes()
    {
        return $this->quotes;
    }

    public function setQuotes($quotes): void
    {
        $this->quotes = $quotes;
    }

}