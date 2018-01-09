<?php

namespace AppBundle\Service\Helper;

use Endroid\Twitter\Twitter;

/**
 * Class TwitterHelper
 */
class TwitterHelper
{
    /**
     * @var Twitter
     */
    private $twitter;

    /**
     * @var array
     */
    private $options;

    /**
     * @param $consumerKey
     * @param $consumerSecret
     * @param $accessToken
     * @param $accessSecret
     */
    public function __construct($consumerKey, $consumerSecret, $accessToken, $accessSecret){
        $this->twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessSecret);
        $this->options = array();
    }

    /**
     * @return array
     */
    public function getResponse() {
        $response = $this->twitter->query('/statuses/user_timeline', 'GET', 'json', $this->options);

        return json_decode($response->getContent(), true);
    }

    /**
     * @param $key
     * @param $value
     */
    public function addOption($key, $value){
        $this->options[$key] = $value;
    }
}