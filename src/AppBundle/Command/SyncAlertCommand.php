<?php

namespace AppBundle\Command;

use AppBundle\Entity\Alert\TwitterAlert;
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

class SyncAlertCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    public function configure()
    {
        $this
            ->setName('sync:alert')
            ->setDescription('Sync alerts')
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
     *
     * @return void
     */
    protected function sync(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        // Sync Tweets
        $username = "officialmcafee";
        $tweets = $this->getContainer()->get('twitter.wrapper')->getLastUserTweets($username);

        foreach($tweets as $tweet){
            if (array_key_exists('id_str', $tweet)){
                $alert = $em->getRepository('AppBundle:Alert\TwitterAlert')->findOneBy(array(
                   "originalId" => $tweet['id_str']
                ));

                if (!$alert){
                    $alert = new TwitterAlert();

                    $em->persist($alert);
                }


                $alert->setOriginalId($tweet['id_str']);
                $alert->setValue($tweet['text']);
                $alert->setAuthor($username);
                $alert->setUrl("https://twitter.com/anyuser/status/" . $alert->getOriginalId());

                $em->flush();
            }
        }

        $em->flush();
    }
}