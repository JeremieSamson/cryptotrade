<?php

namespace AppBundle\Service\Helper;

use AppBundle\Model\CoinCap\CoinCapBasicCoin;
use AppBundle\Model\CoinCap\CoinCapCoin;
use AppBundle\Model\CoinCap\CoinCapFront;
use AppBundle\Model\CoinCap\CoinCapGlobal;
use AppBundle\Service\WebService;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @see https://github.com/CoinCapDev/CoinCap.io
 *
 * Class CoinCapHelper
 */
class CoinCapHelper extends WebService
{
    const API = "https://coincap.io";
    const VERSION = "";

    /**
     * Constructor
     */
    public function __construct(){
        $this->setBaseUrl(self::API);
    }

    /**
     * @return array
     */
    public function getCoins(){
        $unmappedCoins = $this->get("coins");
        $mappedCoins = array();

        foreach($unmappedCoins as $acronym){
            array_push($mappedCoins, $acronym);
        }

        return $mappedCoins;
    }

    /**
     * @inheritdoc
     *   {
     *       "aliases": [],
     *       "name": "300 Token",
     *       "symbol": "300"
     *   }
     *
     * @return ArrayCollection
     */
    public function getMap(){
        $unmappedCoins = $this->get("map");
        $mappedCoins = array();

        foreach($unmappedCoins as $coin){
            $mappedCoins[$coin['symbol']] = $coin;
        }

        return $mappedCoins;
    }

    /**
     * @return ArrayCollection
     */
    public function getFront(){
        $unmappedCoins = $this->get("front");

        $mappedCoins = new ArrayCollection();

        foreach($unmappedCoins as $coin){
            $conCapFront = new CoinCapFront();
            $conCapFront->set($coin);

            $mappedCoins->add($conCapFront);
        }

        return $mappedCoins;
    }

    /**
     * @return CoinCapGlobal
     */
    public function getGlobal(){
        $unmappedCoins = $this->get("global");

        $conCapGlobal = new CoinCapGlobal();
        $conCapGlobal->set(array($unmappedCoins));

        return $conCapGlobal;
    }

    /**
     * @return array
     */
    public function getPage($acronym){
        return $this->get("page/$acronym");
    }
}