<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\PriceTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use AppBundle\Entity\Traits\UrlTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * EbaySell
 *
 * @ORM\Table(name="ebay_sell")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EbaySellRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class EbaySell
{
    use NameTrait, PriceTrait, UrlTrait, TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=255)
     */
    private $unit;

    /**
     * @var Miner
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Miner", inversedBy="ebaySells")
     */
    private $miner;

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
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return Miner
     */
    public function getMiner()
    {
        return $this->miner;
    }

    /**
     * @param Miner $miner
     */
    public function setMiner($miner)
    {
        $this->miner = $miner;
    }
}

