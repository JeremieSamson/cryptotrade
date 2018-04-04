<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 21/03/18
 * Time: 13:47
 */

namespace AppBundle\Service\Wrapper;


use AppBundle\Service\Helper\OutputHelper;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class OutputWrapper
 * @package AppBundle\Service\Wrapper
 */
class OutputWrapper
{
    /**
     * @var OutputHelper
     */
    private $helper;

    /**
     * @param OutputHelper $helper
     */
    public function __construct(OutputHelper $helper){
        $this->helper = $helper;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutputInterface(OutputInterface $output){
        $this->helper->setOutputInterface($output);
    }

    /**
     * @param $msg
     */
    public function writelnNormalComment($msg){
        $this->helper->writeln($msg, OutputInterface::VERBOSITY_NORMAL, "comment");
    }

    /**
     * @param $msg
     */
    public function writelnVerboseComment($msg){
        $this->helper->writeln($msg, OutputInterface::VERBOSITY_VERBOSE, "comment");
    }

    /**
     * @param $msg
     */
    public function writelnVeryVerboseComment($msg){
        $this->helper->writeln($msg, OutputInterface::VERBOSITY_VERY_VERBOSE, "comment");
    }

    /**
     * @param $msg
     */
    public function writelnNormalError($msg){
        $this->helper->writeln($msg, OutputInterface::VERBOSITY_NORMAL, "error");
    }

    /**
     * @param $msg
     */
    public function writelnVerboseError($msg){
        $this->helper->writeln($msg, OutputInterface::VERBOSITY_VERBOSE, "error");
    }

    /**
     * @param $msg
     */
    public function writelnVeryVerboseError($msg){
        $this->helper->writeln($msg, OutputInterface::VERBOSITY_VERY_VERBOSE, "error");
    }
}