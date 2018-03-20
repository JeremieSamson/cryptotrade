<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Rig
 *
 * @ORM\Table(name="rig")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RigRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Rig
{
    use NameTrait, TimestampableTrait;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Gpu", mappedBy="rigs")
     */
    private $gpus;

    /**
     * @var integer
     *
     * @ORM\Column()
     */
    private $supportPrice;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="rigs")
     */
    private $owner;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\BlockchainAddress", inversedBy="rigs")
     */
    private $blockchainAddresses;

    /**
     * Rig constructor.
     */
    public function __construct()
    {
        $this->gpus = new ArrayCollection();
        $this->blockchainAddresses = new ArrayCollection();
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
     * @param Gpu $gpu
     * @return $this
     */
    public function addGpu(Gpu $gpu){
        $this->gpus->add($gpu);

        $gpu->addRig($this);

        return $this;
    }

    /**
     * @param Gpu $gpu
     * @return $this
     */
    public function removeGpu(Gpu $gpu){
        $this->gpus->removeElement($gpu);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGpus(){
        return $this->gpus;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param BlockchainAddress $address
     *
     * @return Rig
     */
    public function addBlockchainAddress(BlockchainAddress $address)
    {
        $this->blockchainAddresses->add($address);

        return $this;
    }

    /**
     * @param BlockchainAddress $address
     *
     * @return Rig
     */
    public function removeBlockchainAddress(BlockchainAddress $address)
    {
        $this->blockchainAddresses->removeElement($address);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBlockchainAddresses(){
        return $this->blockchainAddresses;
    }

    /**
     * @return int
     */
    public function getSupportPrice()
    {
        return $this->supportPrice;
    }

    /**
     * @param int $supportPrice
     */
    public function setSupportPrice($supportPrice)
    {
        $this->supportPrice = $supportPrice;
    }

    /**
     * @return int
     */
    public function getTotalPrice(){
        $price = $this->getSupportPrice();

        /** @var GPU $gpu */
        foreach ($this->gpus as $gpu){
            $price += $gpu->getPrice();
        }

        return $price;
    }

    /**
     * @return int
     */
    public function getNbEthMined(){
        $ethMined = 0;

        /** @var BlockChainAddress $blockchainAddress */
        foreach ($this->getBlockchainAddresses() as $blockchainAddress){
            if ($blockchainAddress->getCryptoCurrency() && $blockchainAddress->getCryptoCurrency()->getAcronym() == CryptoCurrency::ETH_ACRONYM){
                /** @var Transaction $transaction */
                foreach ($blockchainAddress->getToTransactions() as $transaction){
                    if ($transaction->getFromAddress()->isPool())
                        $ethMined += $transaction->getValue();
                }
            }
        }

        return $ethMined;
    }
}

