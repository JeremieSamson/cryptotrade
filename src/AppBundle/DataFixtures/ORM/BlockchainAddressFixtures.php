<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 02/03/18
 * Time: 18:15
 */

namespace AppBundle\ORM\DataFixtures;

use AppBundle\Entity\BlockChainAddress;
use AppBundle\Entity\CryptoCurrency;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class BlockchainAddressFixtures
 * @package AppBundle\ORM\DataFixtures
 */
class BlockchainAddressFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \Doctrine\Common\DataFixtures\BadMethodCallException
     */
    public function load(ObjectManager $manager)
    {
        /** @var CryptoCurrency $ether */
        $ether = $this->getReference('cryptocurrency_eth');

        // Ethermine
        $blockchainAddress = new BlockChainAddress();
        $blockchainAddress->setName("Ethermine");
        $blockchainAddress->setAddress("0xea674fdde714fd979de3edf0f56aa9716b898ec8");
        $blockchainAddress->setPool(true);

        $manager->persist($blockchainAddress);

        $ether->addBlockchainAddress($blockchainAddress);

        // Rigs
        $blockchainAddress = new BlockChainAddress();
        $blockchainAddress->setName("Author Rigs");
        $blockchainAddress->setAddress("0x86D1F3352107bf2ebBd9B991b21D2e8893dEd756");
        $this->addReference('ethAddress_author', $blockchainAddress);

        $manager->persist($blockchainAddress);

        $ether->addBlockchainAddress($blockchainAddress);

        $this->addReference('blockChainAddress_author', $blockchainAddress);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}