<?php

namespace AppBundle\Model\CoinCap;

/**
 * Class CoinCapBasicCoin
 */
class CoinCapBasicCoin
{
    /**
     * @var string
     */
    private $acronym;

    /**
     * Constructor
     */
    public function __constructor($acronym){
        $this->acronym = $acronym;
    }

    /**
     * @return string
     */
    public function getAcronym(){
        return $this->acronym;
    }

    /**
     * @param string $acronym
     */
    public function setAcronym($acronym){
        $this->acronym = $acronym;
    }
}