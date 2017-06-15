<?php

namespace AppBundle\Service\Helper;

/**
 * Class CurrencyHelper
 */
class CurrencyHelper
{
    const API = "https://api.coinbase.com";
    const VERSION = "v2";
    const EXCHANGE_RATE = "exchange-rates";

    /**
     * @param $acronym
     *
     * @return int
     */
    public function getCurrentPrice($acronym) {
        $param = "currency";

        $result = file_get_contents(self::API . '/' . self::VERSION . '/' . self::EXCHANGE_RATE . '?' . $param . "=$acronym");
        $json = json_decode($result);

        return $json->data->rates->EUR;
    }
}