<?php

namespace App\Entity;

use App\Traits\AddressTrait;
use App\Traits\DatedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="cm_clients")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Client
{

    use AddressTrait;
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
     * @ORM\Column(name="registration_number", length=30)
     * @Assert\NotBlank()
     */
    protected $registrationNumber;

    /**
     * @ORM\Column(name="vat_number", length=30, nullable=true)
     * @Assert\NotBlank()
     */
    protected $vatNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="client", orphanRemoval=true)
     */
    protected $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function id()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function name()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function registrationNumber()
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber($registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;
    }

    public function projects()
    {
        return $this->projects;
    }

    public function setProjects($projects)
    {
        $this->projects = $projects;
    }

    public function vatNumber()
    {
        return $this->vatNumber;
    }

    public function setVatNumber($vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

}