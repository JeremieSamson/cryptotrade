<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 02/03/18
 * Time: 18:15
 */

namespace UserBundle\ORM\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class UserFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEnabled(1);

        $email = "user@cryptobox.com";
        $user->setEmail($email);
        $user->setUsername("user");
        $user->setPlainPassword("user");
        $user->addRole(User::ROLE_DEFAULT);
        $this->addReference('user_user', $user);

        $manager->persist($user);

        // Create admin user
        $user = new User();
        $user->setEnabled(1);

        $email = "admin@cryptobox.com";
        $user->setEmail($email);
        $user->setUsername("admin");
        $user->setPlainPassword("admin");
        $user->addRole(User::ROLE_SUPER_ADMIN);
        $this->addReference('user_admin', $user);

        $manager->persist($user);

        $manager->flush();
    }
}