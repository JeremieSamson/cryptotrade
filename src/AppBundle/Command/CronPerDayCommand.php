<?php

namespace AppBundle\Command;

use AppBundle\Service\Synchroniser;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronPerDayCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    public function configure()
    {
        $this
            ->setName('cryptobox:cron:day')
            ->setDescription('Sync provider prices')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    function execute(InputInterface $input, OutputInterface $output)
    {
        // Showing when the script is launched
        $now = new \DateTime();

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE)
            $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        // Executing sync
        $this->sync($input, $output);

        // Showing when the script is over
        $now = new \DateTime();

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE)
            $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function sync(InputInterface $input, OutputInterface $output)
    {
        /** @var Synchroniser $synchroniser */
        $synchroniser = $this->getContainer()->get('synchroniser');
        $synchroniser->setOutput($output);

        // Sync miner prices
        //$synchroniser->syncMinersPrice();

        // Get last ebay sell
        //$synchroniser->getLastEbayPrice();

        // Sync transactions on specific address
        $synchroniser->syncTransaction();
    }
}