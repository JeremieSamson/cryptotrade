<?php

namespace AppBundle\Service;

use AppBundle\Entity\Alert\TwitterAlert;
use AppBundle\Entity\CryptoCurrency;
use AppBundle\Service\Wrapper\CoinCapWrapper;
use AppBundle\Service\Wrapper\TwitterWrapper;

use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Synchroniser
 */
class Synchroniser
{
    /** @var EntityManager */
    private $em;

    /** @var TwitterWrapper */
    private $twitterWrapper;

    /** @var Output */
    private $output;

    /** @var CoinCapWrapper */
    private $coinCapWrapper;

    /**
     * Synchroniser constructor.
     *
     * @param EntityManager $em
     * @param TwitterWrapper $twitterWrapper
     */
    public function __construct(EntityManager $em, TwitterWrapper $twitterWrapper, CoinCapWrapper $coinCapWrapper){
        $this->em = $em;
        $this->twitterWrapper = $twitterWrapper;
        $this->coinCapWrapper = $coinCapWrapper;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output){$this->output = $output;}

    /**
     * Sync aller alerts from Twitter
     */
    public function syncTwitterAlert(){
        $username = "officialmcafee";
        $tweets = $this->twitterWrapper->getLastUserTweets($username);

        $this->writln(count($tweets) . " alerts found");

        foreach($tweets as $tweet){
            if (array_key_exists('id_str', $tweet)){
                $alert = $this->em->getRepository('AppBundle:Alert\TwitterAlert')->findOneBy(array(
                    "originalId" => $tweet['id_str']
                ));

                if (!$alert){
                    $alert = new TwitterAlert();

                    $this->writln("New twitter alert added");

                    $this->em->persist($alert);
                }

                $alert->setOriginalId($tweet['id_str']);
                $alert->setValue($tweet['text']);
                $alert->setAuthor($username);
                $alert->setUrl("https://twitter.com/anyuser/status/" . $alert->getOriginalId());

                $this->writln($alert->getOriginalId() . " updated", OutputInterface::VERBOSITY_VERY_VERBOSE);
            }
        }

        $this->em->flush();
    }

    /**
     * Sync coins from coin cap
     */
    public function syncCoins(){
        $coins = $this->coinCapWrapper->getMap();

        $this->writln(count($coins) . " coins found");

        /**
         * {
         *  'aliases' =>
         *    array(0) {
         *  }
         *  'name' => string(9) "300 Token"
         *  'symbol' => string(3) "300"
         * }
         */
        foreach($coins as $coin) {
            if (!array_key_exists('name', $coin) && !array_key_exists('symbol', $coin))
                continue;

            $crypto = $this->em->getRepository("AppBundle:CryptoCurrency")->findOneBy(
                array("acronym" => $coin['symbol'])
            );

            if (!$crypto) {
                $crypto = new CryptoCurrency();

                $crypto->setAcronym($coin['symbol']);
                $crypto->setValue(0);

                $this->writln("New coin added " . $crypto->getAcronym());

                $this->em->persist($crypto);
            }

            $this->writln($crypto->getAcronym() . " updated", OutputInterface::VERBOSITY_VERY_VERBOSE);
            $crypto->setName(empty($coin['name']) ? $coin['symbol'] : $coin['name']);
        }

        $this->em->flush();
    }

    /**
     * Sync coin prices
     */
    public function syncPrices()
    {
        $currencies = $this->em->getRepository("AppBundle:CryptoCurrency")->findAll();

        $this->writln(count($currencies) . " coins found");

        /** @var CryptoCurrency $currency */
        foreach($currencies as $currency) {
            try{
                $value = $this->coinCapWrapper->getPrice($currency);

                if (is_float($value)) {
                    $this->writln($currency->getAcronym() . " value updated from " . $currency->getValue() . " to " . $value, OutputInterface::VERBOSITY_VERY_VERBOSE);

                    $currency->setValue($value);
                }
            }catch(\Exception $e){
                $this->writln("Can't get current price of " . $currency->getAcronym() . " : " . $e->getMessage(), OutputInterface::VERBOSITY_VERBOSE, "error");
            }

            $this->em->flush();
        }
    }

    /**
     * @param $msg
     * @param int $verbosity
     * @param string $type
     */
    private function writln($msg, $verbosity = OutputInterface::VERBOSITY_VERBOSE, $type = "comment"){
        if ($this->output && $this->output->getVerbosity() >= $verbosity){
            $this->output->writeln("<$type>$msg</$type>");
        }
    }
}