<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 02/03/18
 * Time: 18:15
 */

namespace AppBundle\ORM\DataFixtures;

use AppBundle\Entity\Miner;
use AppBundle\Entity\Provider;
use AppBundle\Entity\Traits\UnitTrait;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class MinerFixtures
 * @package AppBundle\ORM\DataFixtures
 */
class MinerFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Antminer S9
        $miner = new Miner();
        $miner->setName('Antminer S9');
        $miner->setHashrate(13.5);
        $miner->setUnit(UnitTrait::$units['T']);
        $miner->setWatt(1300);
        $miner->setPrice(1915);
        $miner->setUrl("http://shop.bitmain.com/productDetail.htm?pid=00020180302150312633JY56ySU6064D");

        /** @var Provider $bitmainProvider */
        $bitmainProvider = $this->getReference('provider-bitmain');
        $bitmainProvider->addMiner($miner);

        $manager->persist($miner);

        // Antminer T9+
        $miner = new Miner();
        $miner->setName('Antminer T9+');
        $miner->setHashrate(10.5);
        $miner->setUnit(UnitTrait::$units['T']);
        $miner->setWatt(1400);
        $miner->setPrice(1235);
        $miner->setUrl("http://shop.bitmain.com/productDetail.htm?pid=00020180303094209912SJ2nBK2g0658");

        /** @var Provider $bitmainProvider */
        $bitmainProvider = $this->getReference('provider-bitmain');
        $bitmainProvider->addMiner($miner);

        $manager->persist($miner);

        // Antminer L3+
        $miner = new Miner();
        $miner->setName('Antminer L3+');
        $miner->setHashrate(504);
        $miner->setUnit(UnitTrait::$units['M']);
        $miner->setWatt(800);
        $miner->setPrice(1396);
        $miner->setUrl("http://shop.bitmain.com/productDetail.htm?pid=000201802231346322280rNE8Q2F0627");

        /** @var Provider $bitmainProvider */
        $bitmainProvider = $this->getReference('provider-bitmain');
        $bitmainProvider->addMiner($miner);

        $manager->persist($miner);

        // Antminer V9
        $miner = new Miner();
        $miner->setName('Antminer V9');
        $miner->setHashrate(4);
        $miner->setUnit(UnitTrait::$units['T']);
        $miner->setWatt(1027);
        $miner->setPrice(345);
        $miner->setUrl("http://shop.bitmain.com/productDetail.htm?pid=000201802051016159150g4OS2hk0661");

        /** @var Provider $bitmainProvider */
        $bitmainProvider = $this->getReference('provider-bitmain');
        $bitmainProvider->addMiner($miner);

        $manager->persist($miner);

        // Antminer A3
        $miner = new Miner();
        $miner->setName('Antminer A3');
        $miner->setHashrate(815);
        $miner->setUnit(UnitTrait::$units['G']);
        $miner->setWatt(1275);
        $miner->setPrice(980);
        $miner->setUrl("http://shop.bitmain.com/productDetail.htm?pid=00020180129095202674bwQAJFdr06CB");

        /** @var Provider $bitmainProvider */
        $bitmainProvider = $this->getReference('provider-bitmain');
        $bitmainProvider->addMiner($miner);

        $manager->persist($miner);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}