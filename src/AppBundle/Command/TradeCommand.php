<?php

namespace AppBundle\Command;

use AppBundle\Entity\CryptoCurrency;
use AppBundle\Entity\CurrencyOrder;
use AppBundle\Service\Wrapper\CurrencyWrapper;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TradeCommand
 */
class TradeCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    public function configure()
    {
        $this
            ->setName('trade')
            ->setDescription('Calculate sell from order history to get profite')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Showing when the script is launched
        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        // Executing sync
        $this->trade($input, $output);

        // Showing when the script is over
        $now = new \DateTime();
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function trade(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $currencies = $em->getRepository("AppBundle:CryptoCurrency")->findAll();

        $avgBought = array();

        /** @var CryptoCurrency $order */
        foreach($currencies as $currency) {
            if (!array_key_exists($currency->getAcronym(), $avgBought))
                $avgBought[$currency->getAcronym()] = array();

            $totalBought = 0;
            $totalCurrency = 0;
            $totalFees = 0;

            /** @var CurrencyOrder $order */
            foreach($currency->getOrders() as $order) {
                $totalBought += $order->getQuantity() * $order->getValue();
                $totalCurrency += $order->getQuantity();
                $totalFees += $order->getFee();
            }

            $totalBought = (float) $totalBought / (float) $totalCurrency;

            if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE)
                $output->writeln("<comment>" . $currency->getAcronym() . " total avg value = " . doubleval($totalBought) . "</comment>");

            $avgBought[$currency->getAcronym()] = $totalBought;
        }

        foreach($currencies as $currency) {
            if ($avgBought[$currency->getAcronym()] < $currency->getValue()) {
                $output->writeln("<comment>" . $currency->getAcronym() . " is higher than when you bought it : " . $avgBought[$currency->getAcronym()] . "€ and current value is " . $currency->getValue() . "€</comment>");
                $total = $currency->getValue() * $currency->getQuantity() - $currency->getPriceBought();
                $output->writeln("<comment>If you sell it now you will get " . round($total, 2). "€</comment>");
            } else {
                $output->writeln("<error>" . $currency->getAcronym() . " can't be selled now, bought at : " . $avgBought[$currency->getAcronym()] . "€ and current value is " . $currency->getValue(). "€</error>");
            }
        }
    }
}