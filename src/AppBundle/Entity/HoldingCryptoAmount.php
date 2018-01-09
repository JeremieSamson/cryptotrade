<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HoldingCryptoAmount
 *
 * @ORM\Table(name="holding_crypto_amount")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HoldingCryptoAmountRepository")
 */
class HoldingCryptoAmount
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
     * @var CryptoCurrency
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CryptoCurrency", inversedBy="holdingCryptoAmount")
     */
    private $cryptoCurrency;

    /**
     * @var Holding
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Holding", inversedBy="holdingCryptoAmounts")
     */
    private $holding;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

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
     * Set cryptoCurrency
     *
     * @param CryptoCurrency $cryptoCurrency
     *
     * @return HoldingCryptoAmount
     */
    public function setCryptoCurrency( CryptoCurrency $cryptoCurrency)
    {
        $this->cryptoCurrency = $cryptoCurrency;

        return $this;
    }

    /**
     * Get cryptoCurrency
     *
     * @return CryptoCurrency
     */
    public function getCryptoCurrency()
    {
        return $this->cryptoCurrency;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return HoldingCryptoAmount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return Holding
     */
    public function getHolding(){
        return $this->holding;
    }

    /**
     * @param Holding $holding
     */
    public function setHolding(Holding $holding){
        $this->holding = $holding;
    }
}

