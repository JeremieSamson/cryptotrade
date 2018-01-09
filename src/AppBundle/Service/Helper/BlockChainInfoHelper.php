<?php

namespace AppBundle\Service\Helper;

/**
 * Class BlockChainInfoHelper
 */
class BlockChainInfoHelper
{
    const API = "https://bitinfocharts.com";
    const VERSION = "";

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