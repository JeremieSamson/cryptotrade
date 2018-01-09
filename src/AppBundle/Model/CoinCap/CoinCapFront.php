<?php

namespace AppBundle\Model\CoinCap;

use AppBundle\Model\Transformable;

/**
 * Class CoinCapFront
 */
class CoinCapFront extends Transformable
{
    /**
     * @var int
     */
    private $cap24hrChange;

    /**
     * @var string
     */
    private $long;

    /**
     * @var int
     */
    private $mktcap;

    /**
     * @var int
     */
    private $perc;

    /**
     * @var int
     */
    private $price;

    /**
     * @var bool
     */
    private $shapeshift;

    /**
     * @var string
     */
    private $short;

    /**
     * @var int
     */
    private $supply;

    /**
     * @var int
     */
    private $usdVolume;

    /**
     * @var int
     */
    private $volume;

    /**
     * @var int
     */
    private $vwapData;

    /**
     * @var int
     */
    private $vwapDataBTC;

    public function getCap24hrChange(){
        return $this->cap24hrChange;
    }

    public function setCap24hrChange($cap24hrChange){
        $this->cap24hrChange = $cap24hrChange;
    }

    public function getLong(){
        return $this->long;
    }

    public function setLong($long){
        $this->long = $long;
    }

    public function getMktcap(){
        return $this->mktcap;
    }

    public function setMktcap($mktcap){
        $this->mktcap = $mktcap;
    }

    public function getPerc(){
        return $this->perc;
    }

    public function setPerc($perc){
        $this->perc = $perc;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public function getShapeshift(){
        return $this->shapeshift;
    }

    public function setShapeshift($shapeshift){
        $this->shapeshift = $shapeshift;
    }

    public function getShort(){
        return $this->short;
    }

    public function setShort($short){
        $this->short = $short;
    }

    public function getSupply(){
        return $this->supply;
    }

    public function setSupply($supply){
        $this->supply = $supply;
    }

    public function getUsdVolume(){
        return $this->usdVolume;
    }

    public function setUsdVolume($usdVolume){
        $this->usdVolume = $usdVolume;
    }

    public function getVolume(){
        return $this->volume;
    }

    public function setVolume($volume){
        $this->volume = $volume;
    }

    public function getVwapData(){
        return $this->vwapData;
    }

    public function setVwapData($vwapData){
        $this->vwapData = $vwapData;
    }

    public function getVwapDataBTC(){
        return $this->vwapDataBTC;
    }

    public function setVwapDataBTC($vwapDataBTC){
        $this->vwapDataBTC = $vwapDataBTC;
    }
}