<?php

namespace AppBundle\Command;

use AppBundle\Entity\CryptoCurrency;
use AppBundle\Model\CoinCap\CoinCapBasicCoin;
use AppBundle\Model\CoinCap\CoinCapCoin;
use AppBundle\Service\Wrapper\CoinCapWrapper;
use AppBundle\Service\Wrapper\CurrencyWrapper;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SyncCoinsCommand
 */
class SyncCoinsCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    public function configure()
    {
        $this
            ->setName('sync:coins')
            ->setDescription('Sync all crypto currency coins')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Showing when the script is launched
        $now = new \DateTime();

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE)
            $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        // Executing sync
        $this->sync($input, $output);

        // Showing when the script is over
        $now = new \DateTime();

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE)
            $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function sync(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        /** @var CoinCapWrapper $currencyWrapper */
        $currencyWrapper = $this->getContainer()->get('coincap.wrapper');

        /**
         * {
         *  'aliases' =>
         *    array(0) {
         *  }
         *  'name' => string(9) "300 Token"
         *  'symbol' => string(3) "300"
         * }
         */
        foreach($currencyWrapper->getMap() as $coin) {
            if (!array_key_exists('name', $coin) && !array_key_exists('symbol', $coin))
                continue;

            $crypto = $em->getRepository("AppBundle:CryptoCurrency")->findOneBy(
                array("acronym" => $coin['symbol'])
            );

            if (!$crypto) {
                $crypto = new CryptoCurrency();

                $crypto->setAcronym($coin['symbol']);
                $crypto->setValue(0);

                $em->persist($crypto);
            }

            if (array_key_exists('name', $coin))
                $crypto->setName($coin['name']);
        }

        $em->flush();
    }
}