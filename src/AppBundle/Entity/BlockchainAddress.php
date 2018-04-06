<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * BlockChainAddress
 *
 * @ORM\Table(name="blockchain_address")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BlockchainAddressRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class BlockchainAddress
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
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var bool
     *
     * @ORM\Column(name="pool", type="boolean")
     */
    private $pool = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Rig", mappedBy="blockchainAddresses")
     */
    private $rigs;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Transaction", mappedBy="fromAddress")
     */
    private $fromTransactions;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Transaction", mappedBy="toAddress")
     * @ORM\OrderBy({"createdAt" = "desc"})
     */
    private $toTransactions;

    /**
     * @var CryptoCurrency
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CryptoCurrency", inversedBy="blockchainAddresses")
     */
    private $cryptoCurrency;

    /**
     * EthAddress constructor.
     */
    public function __construct()
    {
        $this->rigs = new ArrayCollection();
        $this->fromTransactions = new ArrayCollection();
        $this->toTransactions = new ArrayCollection();
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
     * Set address
     *
     * @param string $address
     *
     * @return BlockChainAddress
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set pool
     *
     * @param boolean $pool
     *
     * @return BlockChainAddress
     */
    public function setPool($pool)
    {
        $this->pool = $pool;

        return $this;
    }

    /**
     * Get pool
     *
     * @return bool
     */
    public function isPool()
    {
        return $this->pool;
    }

    /**
     * @param Rig $rig
     *
     * @return BlockChainAddress
     */
    public function addRig(Rig $rig){
        $this->rigs->add($rig);

        $rig->addBlockchainAddress($this);

        return $this;
    }

    /**
     * @param Rig $rig
     * @return $this
     */
    public function removeRig(Rig $rig){
        $this->rigs->removeElement($rig);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRigs(){
        return $this->rigs;
    }

    /**
     * @param Transaction $transaction
     * @return $this
     */
    public function addFromTransaction(Transaction $transaction){
        $this->fromTransactions->add($transaction);

        $transaction->setFromAddress($this);

        return $this;
    }

    /**
     * @param Transaction $transaction
     * @return $this
     */
    public function removeFromTransaction(Transaction $transaction){
        $this->fromTransactions->removeElement($transaction);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFromTransactions(){
        return $this->fromTransactions;
    }

    /**
     * @param Transaction $transaction
     * @return $this
     */
    public function addToTransaction(Transaction $transaction){
        $this->toTransactions->add($transaction);

        $transaction->setToAddress($this);

        return $this;
    }

    /**
     * @param Transaction $transaction
     * @return $this
     */
    public function removeToTransaction(Transaction $transaction){
        $this->toTransactions->removeElement($transaction);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getToTransactions(){
        return $this->toTransactions;
    }

    /**
     * @return CryptoCurrency
     */
    public function getCryptoCurrency()
    {
        return $this->cryptoCurrency;
    }

    /**
     * @param CryptoCurrency $cryptoCurrency
     */
    public function setCryptoCurrency($cryptoCurrency)
    {
        $this->cryptoCurrency = $cryptoCurrency;
    }
}

