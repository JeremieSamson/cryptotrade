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
use AppBundle\Entity\EthAddress;
use AppBundle\Entity\Gpu;
use AppBundle\Entity\Rig;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

/**
 * Class RigFixtures
 * @package AppBundle\ORM\DataFixtures
 */
class RigFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var User $user */
        $user = $this->getReference('user_user');

        /** @var BlockChainAddress $authorEthAddress */
        $authorEthAddress = $this->getReference('blockChainAddress_author');

        // RIG 1070
        $rig = new Rig();
        $rig->setName('RIG 1070');
        $rig->setSupportPrice(400);
        $user->addRig($rig);
        $authorEthAddress->addRig($rig);

        /** @var Gpu $gpu */
        $gpu = $this->getReference('gpu-1070');

        for($i=0 ; $i<6 ; $i++){
            $gpuRig = new Gpu();
            $gpuRig->setName($gpu->getName());
            $gpuRig->setPrice($gpu->getPrice());

            $manager->persist($gpuRig);

            $rig->addGpu($gpuRig);
        }

        $manager->persist($rig);

        $manager->flush();

        // RIG 1060
        $rig = new Rig();
        $rig->setName('RIG 1060');
        $rig->setSupportPrice(500);

        $user->addRig($rig);
        $authorEthAddress->addRig($rig);

        /** @var Gpu $gpu */
        $gpu = $this->getReference('gpu-1060');

        for($i=0 ; $i<12 ; $i++){
            $gpuRig = new Gpu();
            $gpuRig->setName($gpu->getName());
            $gpuRig->setPrice($gpu->getPrice());

            $manager->persist($gpuRig);

            $rig->addGpu($gpuRig);
        }

        $manager->persist($rig);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 6;
    }
}