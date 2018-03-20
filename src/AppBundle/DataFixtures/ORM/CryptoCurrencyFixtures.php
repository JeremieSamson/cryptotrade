<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 02/03/18
 * Time: 18:15
 */

namespace AppBundle\ORM\DataFixtures;

use AppBundle\Entity\CryptoCurrency;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CryptoCurrencyFixtures
 * @package AppBundle\ORM\DataFixtures
 */
class CryptoCurrencyFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $ether = new CryptoCurrency();
        $ether->setName("Ethereum");
        $ether->setAcronym("ETH");
        $ether->setValue(610.95);
        $ether->setDecimals(18);

        $this->addReference('cryptocurrency_eth', $ether);

        $manager->persist($ether);

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