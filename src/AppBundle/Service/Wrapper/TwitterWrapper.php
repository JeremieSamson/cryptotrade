<?php

namespace AppBundle\Service\Wrapper;

use AppBundle\Service\Helper\CurrencyHelper;
use AppBundle\Service\Helper\TwitterHelper;

/**
 * Class TwitterWrapper
 */
class TwitterWrapper
{
    /**
     * @var TwitterHelper
     */
    private $helper;

    /**
     * @param TwitterHelper $helper
     */
    public function __construct(TwitterHelper $helper){
        $this->helper = $helper;
    }

    /**
     * Get last user tweet without answer from feed
     *
     * @param $screenName
     *
     * @return array
     */
    public function getLastUserTweet($screenName){
        $this->helper->addOption("screen_name", $screenName);
        $this->helper->addOption("exclude_replies", true);
        $this->helper->addOption("count", 1);

        return $this->helper->getResponse();
    }

    /**
     * Get last user tweet without answer from feed
     *
     * @param $screenName
     * @param $max
     *
     * @return array
     */
    public function getLastUserTweets($screenName, $max = 20){
        $this->helper->addOption("screen_name", $screenName);
        $this->helper->addOption("exclude_replies", true);
        $this->helper->addOption("count", $max);

        return $this->helper->getResponse();
    }
}