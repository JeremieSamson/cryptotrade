<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 02/03/18
 * Time: 18:15
 */

namespace AppBundle\ORM\DataFixtures;

use AppBundle\Entity\CryptoCurrency;
use AppBundle\Entity\Gpu;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class GpuFixtures
 * @package AppBundle\ORM\DataFixtures
 */
class GpuFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // GTX 1060
        $gpu = new Gpu();
        $gpu->setName("GTX 1060");
        $gpu->setPrice('259.90');
        $this->addReference('gpu-1060', $gpu);

        $manager->persist($gpu);

        // GTX 1070
        $gpu = new Gpu();
        $gpu->setName("GTX 1070");
        $gpu->setPrice('412');
        $this->addReference('gpu-1070', $gpu);

        $manager->persist($gpu);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 5;
    }
}