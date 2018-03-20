<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use AppBundle\Entity\Traits\UrlTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="provider")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProviderRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Provider
{
    use NameTrait, UrlTrait, TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Miner", mappedBy="provider")
     */
    private $miners;

    /**
     * Provider constructor.
     */
    public function __construct(){
        $this->miners = new ArrayCollection();
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
     * @param Miner $miner
     * @return $this
     */
    public function addMiner(Miner $miner){
        $this->miners->add($miner);

        $miner->setProvider($this);

        return $this;
    }

    /**
     * @param Miner $miner
     * @return $this
     */
    public function removeMiner(Miner $miner){
        $this->miners->removeElement($miner);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMiners(){
        return $this->miners;
    }
}

