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
use AppBundle\Entity\Rig;
use AppBundle\Entity\Setting;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

/**
 * Class SettingFixtures
 * @package AppBundle\ORM\DataFixtures
 */
class SettingFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Add setting to the simple user
        /** @var User $user */
        $user = $this->getReference('user_user');
        $setting = new Setting();
        $user->setSetting($setting);

        $manager->persist($setting);

        // Add setting to the admin user
        /** @var User $user */
        $user = $this->getReference('user_admin');
        $setting = new Setting();
        $user->setSetting($setting);

        $manager->persist($setting);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 7;
    }
}