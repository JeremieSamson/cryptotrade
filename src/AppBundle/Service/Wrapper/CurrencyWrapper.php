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
    public function getCoinCurrentPrice($acronym){
        return $this->helper->getCurrentPrice($acronym);
    }
}