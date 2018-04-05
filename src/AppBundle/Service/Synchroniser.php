<?php

namespace AppBundle\Service;

use AppBundle\Entity\Alert\TransactionAlert;
use AppBundle\Entity\Alert\TwitterAlert;
use AppBundle\Entity\BlockchainAddress;
use AppBundle\Entity\CryptoCurrency;
use AppBundle\Entity\EbaySell;
use AppBundle\Entity\Historic;
use AppBundle\Entity\Miner;
use AppBundle\Entity\Rig;
use AppBundle\Entity\Transaction;
use AppBundle\Service\Grabber\WebsiteGrabber;
use AppBundle\Service\Helper\EtherScanHelper;
use AppBundle\Service\Wrapper\CoinCapWrapper;
use AppBundle\Service\Wrapper\OutputWrapper;
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

    /** @var OutputWrapper */
    private $output;

    /** @var CoinCapWrapper */
    private $coinCapWrapper;

    /** @var WebsiteGrabber */
    private $grabber;

    /** @var EtherScanHelper */
    private $etherScanHelper;

    /**
     * Synchroniser constructor.
     *
     * @param EntityManager $em
     * @param TwitterWrapper $twitterWrapper
     */
    public function __construct(EntityManager $em, OutputWrapper $output, TwitterWrapper $twitterWrapper, CoinCapWrapper $coinCapWrapper, WebsiteGrabber $grabber, EtherScanHelper $etherScanHelper){
        $this->em = $em;
        $this->twitterWrapper = $twitterWrapper;
        $this->coinCapWrapper = $coinCapWrapper;
        $this->grabber = $grabber;
        $this->etherScanHelper = $etherScanHelper;
        $this->output = $output;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output){$this->output->setOutputInterface($output);}

    /**
     * Sync aller alerts from Twitter
     */
    public function syncTwitterAlert(){
        $username = "officialmcafee";
        $tweets = $this->twitterWrapper->getLastUserTweets($username);

        $this->output->writelnVerboseComment(count($tweets) . " alerts found");

        foreach($tweets as $tweet){
            if (array_key_exists('id_str', $tweet)){
                $alert = $this->em->getRepository('AppBundle:Alert\TwitterAlert')->findOneBy(array(
                    "originalId" => $tweet['id_str']
                ));

                if (!$alert){
                    $alert = new TwitterAlert();

                    $this->output->writelnVerboseComment("New twitter alert added");

                    $this->em->persist($alert);
                }

                $alert->setOriginalId($tweet['id_str']);
                $alert->setValue($tweet['text']);
                $alert->setAuthor($username);
                $alert->setUrl("https://twitter.com/anyuser/status/" . $alert->getOriginalId());

                $this->output->writelnVeryVerboseComment($alert->getOriginalId() . " updated");
            }
        }

        $this->em->flush();
    }

    /**
     * Sync coins from coin cap
     */
    public function syncCoins(){
        $coins = $this->coinCapWrapper->getMap();

        $this->output->writelnVerboseComment(count($coins) . " coins found");

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

                $this->output->writelnVerboseComment("New coin added " . $crypto->getAcronym());

                $this->em->persist($crypto);
            }

            $this->output->writelnVeryVerboseComment($crypto->getAcronym() . " updated");
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

        $this->output->writelnVerboseComment(count($currencies) . " coins found");

        /** @var CryptoCurrency $currency */
        foreach($currencies as $currency) {
            try{
                $value = $this->coinCapWrapper->getPrice($currency);

                if (is_float($value)) {
                    $this->output->writelnVeryVerboseComment($currency->getAcronym() . " value updated from " . $currency->getValue() . " to " . $value);

                    $currency->setValue($value);
                }
            }catch(\Exception $e){
                $this->output->writelnVeryVerboseError("Can't get current price of " . $currency->getAcronym() . " : " . $e->getMessage());
            }

            $this->em->flush();
        }
    }

    /**
     * Sync coin prices
     */
    public function syncMinersPrice()
    {
        $miners = $this->em->getRepository("AppBundle:Miner")->findAll();

        $this->output->writelnVerboseComment(count($miners) . " miner(s) found");

        /** @var Miner $miner */
        foreach($miners as $miner) {
            $tag = $this->grabber->getElementsByClassName(
                $miner->getUrl(),
                "div",
                "price-box"
            );

            if (!$tag){
                $this->output->writelnVeryVerboseError("Error during website importation for " . $miner->getName());
                continue;
            }

            $price = $btcPrice = $ltcPrice = $bchPrice = null;

            /** @var \DOMElement $node */
            foreach ($tag->childNodes as $node){
                $nodeValue = $node->nodeValue;

                // Get Price
                if (strpos($nodeValue, 'USD') !== false){
                    $price = substr($nodeValue, 0, strpos($nodeValue, 'USD')-2);
                } elseif (strpos($nodeValue, 'BTC') !== false
                    && strpos($nodeValue, 'BCH')  !== false
                    && strpos($nodeValue, 'LTC')  !== false
                ){
                    $cryptoPrices = explode(';', $nodeValue);

                    foreach ($cryptoPrices as $cryptoPrice){
                        if (strpos($cryptoPrice, 'BTC') !== false){
                            $cryptoPrice = str_replace('(', '', trim($cryptoPrice));
                            $btcPrice = substr($cryptoPrice, 0, strpos($cryptoPrice, ' BTC'));
                        }elseif (strpos($cryptoPrice, 'BCH') !== false){
                            $cryptoPrice = trim($cryptoPrice);
                            $bchPrice = substr($cryptoPrice, 0, strpos($cryptoPrice, ' BCH'));
                        } elseif (strpos($cryptoPrice, 'LTC') !== false){
                            $cryptoPrice = trim($cryptoPrice);
                            $ltcPrice = substr($cryptoPrice, 0, strpos($cryptoPrice, ' LTC'));
                        }
                    }
                }
            }

            if ($price)
                $this->addNewMinerPriceHistoric($miner, $price, "USD");

            if ($btcPrice)
                $this->addNewMinerPriceHistoric($miner, $btcPrice, "BTC");

            if ($bchPrice)
                $this->addNewMinerPriceHistoric($miner, $bchPrice, "BCH");

            if ($ltcPrice)
                $this->addNewMinerPriceHistoric($miner, $ltcPrice, "LTC");

            $this->em->flush();
        }
    }

    /**
     * Get last ebay price for miner
     */
    public function getLastEbayPrice(){
        $miners = $this->em->getRepository("AppBundle:Miner")->findAll();

        $this->output->writelnVerboseComment(count($miners) . " miner(s) found");

        /** @var Miner $miner */
        foreach($miners as $miner) {
            $keywords = str_replace(' ', '+', strtolower($miner->getName()));
            $domDocument = $this->grabber->getDomDocument("https://www.ebay.fr/sch/i.html?_from=R40&_sacat=0&LH_BIN=1&_sop=15&_nkw=$keywords&_ipg=200&rt=nc");
            $domElement = $domDocument->getElementById("ListViewInner");

            $blacklistWords = array("ebit", "whatsminer", "v9", "s7");

            /** @var \DOMElement $nodeDomElement */
            foreach ($domElement->childNodes as $nodeDomElement){
                if ($nodeDomElement->childNodes) {
                    if (count($nodeDomElement->childNodes) > 3){
                        /** @var \DOMNodeList $title */
                        $title = $nodeDomElement->getElementsByTagName("h3");

                        /** @var \DOMElement $h3 */
                        $h3 = $title->item(0);

                        /** @var \DOMNodeList $aInH3 */
                        $aInH3 = $h3->getElementsByTagName("a");

                        $link = $aInH3->item(0)->getAttribute("href");
                        $titleString = $aInH3->item(0)->getAttribute("title");
                        $titleString = substr($titleString, strlen("Cliquez sur ce lien pour l'afficher "), strlen($titleString));

                        $hasToBeBlacklisted = false;
                        foreach ($blacklistWords as $word){
                            if (strpos(strtolower($titleString), $word) !== false)
                                $hasToBeBlacklisted = true;
                        }

                        if ($hasToBeBlacklisted)
                            continue;

                        $li = $nodeDomElement->getElementsByTagName("li")->item(0);
                        $span = $li->getElementsByTagName("span")->item(0);
                        $price = trim($span->nodeValue);
                        $price = substr($price, 0, strpos($price, ' EUR'));
                        $price = htmlentities($price, null, 'utf-8');
                        $price = str_replace('&Acirc;', '', $price);
                        $sellPrice = intval(str_replace('&nbsp;', '', $price));

                        if ($sellPrice > 500){
                            $ebayHistoric = new EbaySell();
                            $ebayHistoric->setPrice($sellPrice);
                            $ebayHistoric->setUnit('EUR');
                            $ebayHistoric->setName($titleString);
                            $ebayHistoric->setUrl($link);

                            $miner->addEbaySell($ebayHistoric);

                            $this->em->persist($ebayHistoric);
                        }
                    }
                }
            }
        }

        $this->em->flush();
    }

    /**
     * Sync all rigs transactions
     */
    public function syncTransaction(){
        $nbTransactionsCreated = $nbTransactionsPassed = $nbAddressesCreated = $nbAddressesPassed = 0;

        $rigs = $this->em->getRepository('AppBundle:Rig')->findAll();

        $this->output->writelnVerboseComment(count($rigs) . " rig(s) found");

        /** @var CryptoCurrency $eth */
        $eth = $this->em->getRepository('AppBundle:CryptoCurrency')->findOneBy(array("acronym" => "ETH"));

        /** @var Rig $rig */
        foreach ($rigs as $rig){
            $blockchainAddresses =$rig->getBlockchainAddresses();

            $this->output->writelnVerboseComment($blockchainAddresses->count() . " addresses(s) found on rig " . $rig->getName());

            /** @var BlockchainAddress $blockchainAddress */
            foreach ($blockchainAddresses as $blockchainAddress) {
                $transactions = $this->etherScanHelper->getTransactions($blockchainAddress->getAddress());

                $this->output->writelnVerboseComment(count($transactions) . " transaction(s) found on rig  " .$rig->getName(). " and addresses " .$blockchainAddress->getAddress() );

                foreach ($transactions as $etherScanTransaction){
                    /** @var BlockchainAddress $toAddress */
                    $toAddress = $this->em->getRepository('AppBundle:BlockchainAddress')->findOneBy(array("address" => $etherScanTransaction['to']));

                    if (!$toAddress){
                        $toAddress = new BlockchainAddress();
                        $toAddress->setName("N/A");
                        $toAddress->setAddress($etherScanTransaction['to']);

                        $this->output->writelnVeryVerboseComment("New Address created");

                        $nbAddressesCreated++;

                        $this->em->persist($toAddress);
                    } else {
                        $nbAddressesPassed++;
                    }

                    /** @var BlockchainAddress $fromAddress */
                    $fromAddress = $this->em->getRepository('AppBundle:BlockchainAddress')->findOneBy(array("address" => $etherScanTransaction['from']));

                    if (!$fromAddress){
                        $fromAddress = new BlockchainAddress();
                        $fromAddress->setName("N/A");
                        $fromAddress->setAddress($etherScanTransaction['from']);

                        $this->output->writelnVeryVerboseComment("New Address created");

                        $nbAddressesCreated++;

                        $this->em->persist($fromAddress);
                    } else {
                        $nbAddressesPassed++;
                    }

                    /** @var Transaction $transaction */
                    $transaction = $this->em->getRepository('AppBundle:Transaction')->findOneBy(array("hash" => $etherScanTransaction['hash']));

                    if (!$transaction){
                        $transaction = new Transaction();
                        $transaction->setValue($etherScanTransaction['value'] / pow(10, $eth->getDecimals()));
                        $transaction->setHash($etherScanTransaction['hash']);
                        $transaction->setTimeStamp(new \DateTime("@".$etherScanTransaction['timeStamp']));
                        $transaction->setGas($etherScanTransaction['gas']);

                        $toAddress->addToTransaction($transaction);
                        $fromAddress->addFromTransaction($transaction);

                        $this->output->writelnVeryVerboseComment("New Transaction created");

                        $nbTransactionsCreated++;

                        $this->em->persist($transaction);

                        $alert = new TransactionAlert();
                        $alert->setOriginalId($transaction->getHash());
                        $alert->setValue($transaction->getValue());
                        $alert->setUrl(CryptoCurrency::ETH_ADDRESSES_READER . "/" . $blockchainAddress->getAddress());

                        $transaction->setAlert($alert);

                        $this->em->persist($alert);
                    } else {
                        $nbTransactionsPassed++;
                    }
                }
            }

            $this->em->flush();
        }

        $this->output->writelnVerboseComment("Nb Transaction(s) created : " . $nbTransactionsCreated);
        $this->output->writelnVerboseComment("Nb Transaction(s) passed : " . $nbTransactionsPassed);
        $this->output->writelnVerboseComment("Nb Addresse(s) created : " . $nbAddressesCreated);
        $this->output->writelnVerboseComment("Nb Addresse(s) passed : " . $nbAddressesPassed);
    }

    /**
     * @param Miner $miner
     * @param $value
     * @param $unite
     */
    private function addNewMinerPriceHistoric(Miner $miner, $value, $unite){
        $value = trim($value);

        $historic = new Historic();
        $historic->setObjectId($miner->getId());
        $historic->setObjectClassName(get_class($miner));
        $historic->setValue($value);
        $historic->setUnit($unite);

        $this->writln("New Historic for " . $miner->getName() . " => $value $unite", OutputInterface::VERBOSITY_VERY_VERBOSE);

        $this->em->persist($historic);
    }
}