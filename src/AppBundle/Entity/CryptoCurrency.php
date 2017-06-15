<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CryptoCurrency
 *
 * @ORM\Table(name="trade_crypto_currency")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CryptoCurrencyRepository")
 */
class CryptoCurrency
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="acronym", type="string", length=3, unique=true)
     */
    private $acronym;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CurrencyOrder", mappedBy="currency")
     */
    private $orders;

    /**
     * CryptoCurrency constructor.
     */
    public function __construct()
    {
        $this->orders = new ArrayCollection();
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
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CryptoCurrency
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return CryptoCurrency
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
}

