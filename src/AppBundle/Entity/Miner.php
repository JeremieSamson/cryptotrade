<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\PriceTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use AppBundle\Entity\Traits\UnitTrait;
use AppBundle\Entity\Traits\UrlTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Miner
 *
 * @ORM\Table(name="miner")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MinerRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Miner
{
    use NameTrait, UrlTrait, UnitTrait, PriceTrait, TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="watt", type="integer")
     */
    private $watt;

    /**
     * @var float
     *
     * @ORM\Column(name="hashrate", type="float")
     */
    private $hashrate;

    /**
     * @var Provider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider", inversedBy="miners")
     */
    private $provider;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EbaySell", mappedBy="miner")
     */
    private $ebaySells;

    /**
     * Miner constructor.
     */
    public function __construct()
    {
        $this->ebaySells = new ArrayCollection();
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
     * Set watt
     *
     * @param integer $watt
     *
     * @return Miner
     */
    public function setWatt($watt)
    {
        $this->watt = $watt;

        return $this;
    }

    /**
     * Get watt
     *
     * @return int
     */
    public function getWatt()
    {
        return $this->watt;
    }

    /**
     * @return float
     */
    public function getHashrate()
    {
        return $this->hashrate;
    }

    /**
     * @param float $hashrate
     */
    public function setHashrate($hashrate)
    {
        $this->hashrate = $hashrate;
    }

    /**
     * @return string
     */
    public function getHashrateWithUnite(){
        return $this->getHashrate() . ' ' . array_search($this->getUnit(), UnitTrait::$units) . 'H/s';
    }

    /**
     * @return Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param Provider $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param EbaySell $sell
     * @return $this
     */
    public function addEbaySell(EbaySell $sell){
        $this->ebaySells->add($sell);

        $sell->setMiner($this);

        return $this;
    }

    /**
     * @param EbaySell $sell
     * @return $this
     */
    public function remmoveEbaySell(EbaySell $sell){
        $this->ebaySells->removeElement($sell);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEbaySells(){
        return $this->ebaySells;
    }
}

