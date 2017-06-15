<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurrencyOrder
 *
 * @ORM\Table(name="trade_currency_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CurrencyOrderRepository")
 */
class CurrencyOrder
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CryptoCurrency", inversedBy="orders")
     */
    private $currency;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="fee", type="float")
     */
    private $fee;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="float")
     */
    private $quantity;


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
     * @return CryptoCurrency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param CryptoCurrency $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return CurrencyOrder
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set fee
     *
     * @param integer $fee
     *
     * @return CurrencyOrder
     */
    public function setFee($fee)
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * Get fee
     *
     * @return int
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return CurrencyOrder
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}

