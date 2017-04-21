<?php

namespace AppBundle\Traits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AddressTrait
 * @package AppBundle\Traits
 */
trait AddressTrait
{

    /**
     * @var string
     * @ORM\Column(name="address_line1")
     * @Assert\NotBlank()
     */
    protected $addressLine1;

    /**
     * @var string
     * @ORM\Column(name="address_line2", nullable=true)
     */
    protected $addressLine2;

    /**
     * @var string
     * @ORM\Column(name="city")
     * @Assert\NotBlank()
     */
    protected $city;

    /**
     * @var string
     * @ORM\Column(name="zip_code", length=5)
     * @Assert\NotBlank()
     */
    protected $zipCode;

    /**
     * @var string
     * @ORM\Column(name="country", length=2)
     * @Assert\NotBlank()
     */
    protected $countryCode;

    /**
     * @return string
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @param string $addressLine1
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * @return string
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @param string $addressLine2
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

}