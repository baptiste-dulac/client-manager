<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Table(name="cm_users")
 * @ORM\Entity()
 */
class User extends BaseUser
{

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Client", mappedBy="user", orphanRemoval=true)
     */
    protected $clients;

    public function __construct()
    {
        parent::__construct();
        $this->clients = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @param ArrayCollection $clients
     */
    public function setClients($clients)
    {
        $this->clients = $clients;
    }

}