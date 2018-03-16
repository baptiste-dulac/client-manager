<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @ORM\Column(name="address")
     */
    protected $address;

    /**
     * @ORM\Column(name="city", length=45)
     */
    protected $city;

    /**
     * @ORM\Column(name="zip_code", length=10)
     */
    protected $zipCode;

    /**
     * @ORM\Column(name="registration_number", length=15)
     */
    protected $registrationNumber;

    public function __toString()
    {
        return sprintf('%s - SIREN : %s', $this->name, $this->registrationNumber);
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

    public function address()
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function city()
    {
        return $this->city;
    }

    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function zipCode()
    {
        return $this->zipCode;
    }

    public function setZipCode($zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function registrationNumber()
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber($registrationNumber): void
    {
        $this->registrationNumber = $registrationNumber;
    }

}