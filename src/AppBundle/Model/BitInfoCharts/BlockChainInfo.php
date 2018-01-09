<?php

namespace AppBundle\Model\BitInfoCharts;

/**
 * Class BlockChainInfo
 */
class BlockChainInfo
{
    /**
     * block time in seconds
     *
     * @var int
     */
    private $blockTime;

    /**
     * @return string
     */
    public function getBlockTime(){
        return $this->blockTime;
    }

    /**
     * @param int $blockTime
     */
    public function setBlockTime($blockTime){
        $this->blockTime = $blockTime;
    }
}