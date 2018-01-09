<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Holding
 *
 * @ORM\Table(name="holding")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HoldingRepository")
 */
class Holding
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Plateform or service name (Exodus, HitBtc ...)
     *
     * @var string
     *
     * @ORM\Column(name="from", type="string")
     */
    private $from;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="holdings")
     */
    private $user;

    /**
     * Crypto & amount
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\HoldingCryptoAmount", mappedBy="holding")
     */
    private $holdingCryptoAmounts;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFrom(){
        return $this->from;
    }

    public function setFrom($from){
        $this->from = $from;
    }

    /**
     * @param HoldingCryptoAmount $cryptoAmount
     *
     * @return User
     */
    public function addHoldingCryptoAmount(HoldingCryptoAmount $cryptoAmount){
        $this->holdingCryptoAmounts->add($cryptoAmount);

        $cryptoAmount->setHolding($this);

        return $this;
    }

    /**
     * @param HoldingCryptoAmount $cryptoAmount
     *
     * @return User
     */
    public function removeHoldingCryptoAmount(HoldingCryptoAmount $cryptoAmount){
        $this->holdingCryptoAmounts->removeElement($cryptoAmount);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getHoldingCryptoAmounts(){
        return $this->holdingCryptoAmounts;
    }

    /**
     * @return User
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user){
        $this->user = $user;
    }
}

