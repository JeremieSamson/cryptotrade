<?php

namespace AppBundle\Service\Wrapper;

use AppBundle\Entity\CryptoCurrency;
use AppBundle\Service\Helper\CoinCapHelper;

/**
 * Class CoinCapWrapper
 */
class CoinCapWrapper
{
    /**
     * @var CoinCapHelper
     */
    private $helper;

    /**
     * @param CoinCapHelper $helper
     */
    public function __construct(CoinCapHelper $helper){
        $this->helper = $helper;
    }

    /**
     * @return array
     */
    public function getCoins(){
        return $this->helper->getCoins();
    }

    /**
     * @return array
     */
    public function getMap(){
        return $this->helper->getMap();
    }

    /**
     * @return float
     */
    public function getETHPrice(){
        return $this->getPriceFromAcronym("ETH");
    }

    /**
     * @return float
     */
    public function getBTCPrice(){
        return $this->getPriceFromAcronym("BTC");
    }

    /**
     * @return float
     */
    public function getLTCPrice(){
        return $this->getPriceFromAcronym("LTC");
    }

    /**
     * @return float
     */
    private function getPriceFromAcronym($acronym){
        $result = $this->helper->getPage($acronym);

        return is_array($result) && array_key_exists('price', $result) ? doubleval($result['price']) : null;
    }

    /**
     * @return float
     */
    public function getPrice(CryptoCurrency $cryptoCurrency){
        $result = $this->helper->getPage($cryptoCurrency->getAcronym());

        return is_array($result) && array_key_exists('price', $result) ? doubleval($result['price']) : null;
    }
}