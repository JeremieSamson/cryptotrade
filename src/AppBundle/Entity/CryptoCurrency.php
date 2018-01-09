<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CryptoCurrency
 *
 * @ORM\Table(name="trade_crypto_currency")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CryptoCurrencyRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class CryptoCurrency
{
    use TimestampableTrait;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="acronym", type="string", length=255, unique=true)
     */
    private $acronym;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\HoldingCryptoAmount", mappedBy="cryptoCurrency")
     */
    private $holdingCryptoAmount;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CurrencyOrder", mappedBy="currency")
     */
    private $orders;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CurrencySell", mappedBy="currency")
     */
    private $sells;

    /**
     * CryptoCurrency constructor.
     */
    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->sells = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return CryptoCurrency
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set acronym
     *
     * @param string $acronym
     *
     * @return CryptoCurrency
     */
    public function setAcronym($acronym)
    {
        $this->acronym = $acronym;

        return $this;
    }

    /**
     * Get acronym
     *
     * @return string
     */
    public function getAcronym()
    {
        return $this->acronym;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @param CurrencyOrder $order
     *
     * @return $this
     */
    public function addOrder(CurrencyOrder $order){
        $this->orders->add($order);

        $order->setCurrency($this);

        return $this;
    }

    /**
     * @param CurrencyOrder $order
     *
     * @return $this
     */
    public function removeOrder(CurrencyOrder $order){
        $this->orders->removeElement($order);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrders(){
        return $this->orders;
    }

    /**
     * @return int
     */
    public function getQuantity(){
        $quantity = 0;

        /** @var CurrencyOrder $order */
        foreach($this->orders as $order){
            $quantity += $order->getQuantity();
        }

        return $quantity;
    }

    /**
     * @return int
     */
    public function getPriceBought(){
        $price = 0;

        /** @var CurrencyOrder $order */
        foreach($this->orders as $order){
            $price += $order->getValue() * $order->getQuantity() - $order->getFee();
        }

        return $price;
    }

    /**
     * @param CurrencySell $sell
     *
     * @return $this
     */
    public function addSell(CurrencySell $sell){
        $this->orders->add($sell);

        $sell->setCurrency($this);

        return $this;
    }

    /**
     * @param CurrencySell $sell
     *
     * @return $this
     */
    public function removeSell(CurrencySell $sell){
        $this->orders->removeElement($sell);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSells(){
        return $this->sells;
    }

    /**
     * @param HoldingCryptoAmount $cryptoAmount
     *
     * @return CryptoCurrency
     */
    public function addHoldingCryptoAmount(HoldingCryptoAmount $cryptoAmount){
        $this->holdingCryptoAmount->add($cryptoAmount);

        $cryptoAmount->setCryptoCurrency($this);

        return $this;
    }

    /**
     * @param HoldingCryptoAmount $cryptoAmount
     *
     * @return CryptoCurrency
     */
    public function removeHoldingCryptoAmount(HoldingCryptoAmount $cryptoAmount){
        $this->holdingCryptoAmount->removeElement($cryptoAmount);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getHoldingCryptoAmount(){
        return $this->holdingCryptoAmount;
    }
}

