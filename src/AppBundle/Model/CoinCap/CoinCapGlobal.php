<?php

namespace AppBundle\Model\CoinCap;

use AppBundle\Model\Transformable;

/**
 * Class CoinCapGlobal
 */
class CoinCapGlobal extends Transformable
{
    /**
     * @var int
     */
    private $altCap;

    /**
     * @var int
     */
    private $bitnodesCount;

    /**
     * @var int
     */
    private $btcCap;

    /**
     * @var int
     */
    private $btcPrice;

    /**
     * @var int
     */
    private $dom;

    /**
     * @var int
     */
    private $totalCap;

    /**
     * @var int
     */
    private $volumeAlt;

    /**
     * @var int
     */
    private $volumeBtc;

    /**
     * @var int
     */
    private $volumeTotal;

    public function getAltCap(){
        return $this->altCap;
    }

    public function setAltCap($altCap){
        $this->altCap = $altCap;
    }

    public function getBitnodesCount(){
        return $this->bitnodesCount;
    }

    public function setBitnodesCount($bitnodesCount){
        $this->bitnodesCount = $bitnodesCount;
    }

    public function getBtcCap(){
        return $this->btcCap;
    }

    public function setBtcCap($btcCap){
        $this->btcCap = $btcCap;
    }

    public function getBtcPrice(){
        return $this->btcPrice;
    }

    public function setBtcPrice($btcPrice){
        $this->btcPrice = $btcPrice;
    }

    public function getDom(){
        return $this->dom;
    }

    public function setDom($dom){
        $this->dom = $dom;
    }

    public function getTotalCap(){
        return $this->totalCap;
    }

    public function setTotalCap($totalCap){
        $this->totalCap = $totalCap;
    }

    public function getVolumeAlt(){
        return $this->volumeAlt;
    }

    public function setVolumeAlt($volumeAlt){
        $this->volumeAlt = $volumeAlt;
    }

    public function getVolumeBtc(){
        return $this->volumeBtc;
    }

    public function setVolumeBtc($volumeBtc){
        $this->volumeBtc = $volumeBtc;
    }

    public function getVolumeTotal(){
        return $this->volumeTotal;
    }

    public function setVolumeTotal($volumeTotal){
        $this->volumeTotal = $volumeTotal;
    }
}