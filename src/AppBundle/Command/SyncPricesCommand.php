<?php

namespace AppBundle\Command;

use AppBundle\Entity\CryptoCurrency;
use AppBundle\Service\Wrapper\CoinCapWrapper;
use AppBundle\Service\Wrapper\CurrencyWrapper;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SyncPricesCommand
 */
class SyncPricesCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    public function configure()
    {
        $this
            ->setName('sync:prices')
            ->setDescription('Sync all crypto currency prices')
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

        $currencies = $em->getRepository("AppBundle:CryptoCurrency")->findAll();

        /** @var CoinCapWrapper $currencyWrapper */
        $currencyWrapper = $this->getContainer()->get('coincap.wrapper');

        /** @var CryptoCurrency $currency */
        foreach($currencies as $currency) {
            try{
                $value = $currencyWrapper->getPrice($currency);

                if (is_float($value)) {
                    if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE)
                        $output->writeln("<comment>" . $currency->getAcronym() . " value updated from " . $currency->getValue() . " to " . $value . "</comment>");

                    $currency->setValue($value);
                }
            }catch(\Exception $e){
                $output->writeln("<error>Can't get current price of " . $currency->getAcronym() . " : " . $e->getMessage() . "</error>");
            }

            $em->flush();
        }
    }
}