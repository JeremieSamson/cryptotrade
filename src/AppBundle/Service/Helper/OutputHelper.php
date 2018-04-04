<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 21/03/18
 * Time: 13:47
 */

namespace AppBundle\Service\Helper;

use Symfony\Component\Console\Output\OutputInterface;

class OutputHelper
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @param OutputInterface $output
     */
    public function setOutputInterface(OutputInterface $output){
        $this->output = $output;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput(){
        if ($this->output){
            return $this->output;
        }

        return null;
    }

    /**
     * @param string    $msg
     * @param int       $verbosity
     * @param string    $type
     */
    public function writeln($msg, $verbosity, $type){
        if ($this->output && $this->output->getVerbosity() >= $verbosity){
            $this->output->writeln("<$type>$msg</$type>");
        }
    }
}