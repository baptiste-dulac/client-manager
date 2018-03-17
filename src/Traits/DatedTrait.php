<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait DatedTrait
{

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateDateTimes()
    {
        if (!$this->createdAt)
            $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function createdAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function updatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}