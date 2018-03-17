<?php

namespace App\Entity;

use App\Traits\AddressTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cm_company")
 */
class Company
{

    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    use AddressTrait;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="name", length=50)
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="registration_number", length=30)
     */
    protected $registrationNumber;

    /**
     * @ORM\Column(name="vat_number", length=30, nullable=true)
     * @Assert\NotBlank()
     */
    protected $vatNumber;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="type")
     */
    protected $type;

    public function __toString()
    {
        return sprintf('%s - SIREN : %s', $this->name,
            $this->registrationNumber);
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

    public function registrationNumber()
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber($registrationNumber): void
    {
        $this->registrationNumber = $registrationNumber;
    }

    public function vatNumber()
    {
        return $this->vatNumber;
    }

    public function setVatNumber($vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    public function type()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

}