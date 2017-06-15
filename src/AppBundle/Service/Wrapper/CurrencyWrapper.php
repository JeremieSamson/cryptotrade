<?php

namespace AppBundle\Service\Wrapper;

use AppBundle\Service\Helper\CurrencyHelper;

/**
 * Class CurrencyWrapper
 */
class CurrencyWrapper
{
    /**
     * @var CurrencyHelper
     */
    private $helper;

    /**
     * @param CurrencyHelper $helper
     */
    public function __construct(CurrencyHelper $helper){
        $this->helper = $helper;
    }

    /**
     * @return int
     */
    public function getCurrentPriceForBTC(){
        return $this->helper->getCurrentPrice("BTC");
    }

    /**
     * @return int
     */
    public function getCurrentPriceForETH(){
        return $this->helper->getCurrentPrice("ETH");
    }

    /**
     * @return int
     */
    public function getCurrentPriceForLTC(){
        return $this->helper->getCurrentPrice("LTC");
    }
}