<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait AddressTrait
{
    /**
     * @ORM\Column(name="address_line1")
     * @Assert\NotBlank()
     */
    protected $addressLine1;

    /**
     * @ORM\Column(name="address_line2", nullable=true)
     */
    protected $addressLine2;

    /**
     * @ORM\Column(name="city")
     * @Assert\NotBlank()
     */
    protected $city;

    /**
     * @ORM\Column(name="zip_code", length=5)
     * @Assert\NotBlank()
     */
    protected $zipCode;

    /**
     * @ORM\Column(name="country", length=2)
     * @Assert\NotBlank()
     */
    protected $countryCode;

    public function addressLine1()
    {
        return $this->addressLine1;
    }

    public function setAddressLine1($addressLine1): void
    {
        $this->addressLine1 = $addressLine1;
    }

    public function addressLine2()
    {
        return $this->addressLine2;
    }

    public function setAddressLine2($addressLine2): void
    {
        $this->addressLine2 = $addressLine2;
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

    public function countryCode()
    {
        return $this->countryCode;
    }

    public function setCountryCode($countryCode): void
    {
        $this->countryCode = $countryCode;
    }
}