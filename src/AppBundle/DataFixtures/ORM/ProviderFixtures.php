<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 02/03/18
 * Time: 18:15
 */

namespace AppBundle\ORM\DataFixtures;

use AppBundle\Entity\Provider;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ProviderFixtures
 * @package AppBundle\ORM\DataFixtures
 */
class ProviderFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $provider = new Provider();
        $provider->setName("Bitmain");
        $provider->setUrl("https://shop.bitmain.com");
        $this->addReference('provider-bitmain', $provider);

        $manager->persist($provider);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}