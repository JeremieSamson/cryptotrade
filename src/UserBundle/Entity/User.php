<?php

namespace UserBundle\Entity;

use AppBundle\Entity\Holding;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Holding", mappedBy="user")
     */
    private $holdings;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Holding $holding
     *
     * @return User
     */
    public function addHolding(Holding $holding){
        $this->holdings->add($holding);

        $holding->setUser($this);

        return $this;
    }

    /**
     * @param Holding $holding
     *
     * @return User
     */
    public function removeHolding(Holding $holding){
        $this->holdings->removeElement($holding);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getHoldings(){
       return $this->holdings;
    }
}

