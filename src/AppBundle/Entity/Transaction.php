<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Alert\TransactionAlert;
use AppBundle\Entity\Traits\AlertableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 */
class Transaction
{

    use AlertableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var BlockChainAddress
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BlockChainAddress", inversedBy="fromTransactions")
     */
    private $fromAddress;

    /**
     * @var BlockChainAddress
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BlockChainAddress", inversedBy="toTransactions")
     */
    private $toAddress;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="gas", type="integer")
     */
    private $gas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timeStamp;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255)
     */
    private $hash;

    /**
     * @var TransactionAlert
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Alert\TransactionAlert")
     */
    private $alert;

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
     * @return BlockChainAddress
     */
    public function getFromAddress()
    {
        return $this->fromAddress;
    }

    /**
     * @param BlockChainAddress $fromAddress
     */
    public function setFromAddress(BlockChainAddress $fromAddress)
    {
        $this->fromAddress = $fromAddress;
    }

    /**
     * @return BlockChainAddress
     */
    public function getToAddress()
    {
        return $this->toAddress;
    }

    /**
     * @param BlockChainAddress $toAddress
     */
    public function setToAddress(BlockChainAddress $toAddress)
    {
        $this->toAddress = $toAddress;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return Transaction
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set gas
     *
     * @param integer $gas
     *
     * @return Transaction
     */
    public function setGas($gas)
    {
        $this->gas = $gas;

        return $this;
    }

    /**
     * Get gas
     *
     * @return int
     */
    public function getGas()
    {
        return $this->gas;
    }

    /**
     * @return \DateTime
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * @param \DateTime $timeStamp
     */
    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return TransactionAlert
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * @param TransactionAlert $alert
     */
    public function setAlert($alert)
    {
        $this->alert = $alert;
    }
}

