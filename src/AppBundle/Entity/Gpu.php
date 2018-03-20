<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\PriceTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Gpu
 *
 * @ORM\Table(name="gpu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GpuRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Gpu
{
    use PriceTrait, NameTrait, TimestampableTrait;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Rig", inversedBy="gpus")
     */
    private $rigs;

    /**
     * Gpu constructor.
     */
    public function __construct()
    {
        $this->rigs = new ArrayCollection();
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
     * @param Rig $rig
     *
     * @return Gpu
     */
    public function addRig(Rig $rig)
    {
        $this->rigs->add($rig);

        return $this;
    }

    /**
     * @param Rig $rig
     *
     * @return Gpu
     */
    public function removeRig(Rig $rig)
    {
        $this->rigs->removeElement($rig);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRigs(){
        return $this->rigs;
    }
}

