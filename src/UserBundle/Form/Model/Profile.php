<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 20/03/18
 * Time: 19:00
 */

namespace UserBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Profile
{
    /**
     * @Assert\NotBlank(groups={"profile"})
     *
     * @var string
     */
    private $username;

    /**
     * @Assert\NotBlank(groups={"profile"})
     *
     * @var string
     */
    private $password;

    /**
     * @Assert\NotBlank(groups={"profile"})
     *
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}