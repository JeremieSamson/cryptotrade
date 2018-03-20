<?php

namespace AppBundle\Service\Helper;

/**
 * Class EtherScanHelper
 */
class EtherScanHelper
{
    const API_URL = "https://api.etherscan.io/api";

    /**
     * @var string
     */
    private $apiToken;

    /**
     * EtherScanHelper constructor.
     *
     * @param $apiToken
     */
    public function __construct($apiToken){
        $this->apiToken = $apiToken;
    }

    /**
     * Get Ether Balance for a single Address
     *
     * @param $address
     *
     * @return string
     */
    public function getEtherBalance($address){
        $options = array(
            "module" => "account",
            "action" => "balance",
            "address" => $address
        );

        return $this->getJsonFromUrl($options);
    }

    /**
     * Get a list of 'Normal' Transactions By Address
     * Max 10000 transactions
     *
     * @param $address
     * @return mixed
     */
    public function getTransactions($address){
        $options = array(
            "module" => "account",
            "action" => "txlist",
            "address" => $address,
            "startblock" => 0,
            "endblock" => 99999999,
            "sort" => "asc"
        );

        return $this->getJsonFromUrl($options);
    }

    /**
     * @param $options
     * @return mixed
     */
    private function getJsonFromUrl($options){
        $res = json_decode(file_get_contents($this::API_URL . $this->addOptions($options)), true);

        if (array_key_exists('message', $res) && $res['message'] == "OK" && array_key_exists('result', $res)){
            return $res['result'];
        }

        return null;
    }

    /**
     * @param array $options
     * @return string
     */
    private function addOptions(array $options){
        $args = "";

        foreach ($options as $key => $option) {
            if ($key == "address" && $option[0] != "0" && $option[1] != "x")
                $option = "0x$option";

            $args.= "&$key=$option";
        }

        return "?tag=latest&apiKey=".$this->apiToken . $args;
    }
}