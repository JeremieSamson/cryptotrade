<?php

namespace AppBundle\Command;

use AppBundle\Entity\Alert\TwitterAlert;
use AppBundle\Service\Synchroniser;
use Doctrine\ORM\EntityManager;
use MainBundle\Entity\BonDeLivraison;
use MainBundle\Entity\Chantier;
use MainBundle\Entity\Invoice;
use MainBundle\Entity\Log;
use MainBundle\Entity\Questionnaire;
use MainBundle\Entity\Verification;
use MediaBundle\Entity\GalleryHasMedia;
use MediaBundle\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronPerMinuteCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    public function configure()
    {
        $this
            ->setName('cryptobox:cron:minute')
            ->setDescription('Sync twitter alerts, coins and prices')
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

        // Sync twitter alert
        $synchroniser->syncTwitterAlert();

        // Sync coins
        $synchroniser->syncCoins();

        // Sync prices
        $synchroniser->syncPrices();
    }
}