<?php

namespace AppBundle\Model\CoinCap;

use AppBundle\Model\Transformable;

/**
 * Class CoinCapCoin
 */
class CoinCapCoin extends Transformable
{
    /**
     * @var string
     */
    public $aliases;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $symbol;

    /**
     * @return string
     */
    public function getAliases(){
        return $this->aliases;
    }

    /**
     * @param string $aliases
     */
    public function setAliases($aliases){
        $this->aliases = $aliases;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSymbol(){
        return $this->symbol;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol($symbol){
        $this->symbol = $symbol;
    }
}