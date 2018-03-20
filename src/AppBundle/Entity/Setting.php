<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Setting
 *
 * @ORM\Table(name="setting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingRepository")
 */
class Setting
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="ebay", type="boolean")
     */
    public $ebay = false;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ebay
     *
     * @param boolean $ebay
     *
     * @return Setting
     */
    public function setEbay($ebay)
    {
        $this->ebay = $ebay;

        return $this;
    }

    /**
     * Get ebay
     *
     * @return bool
     */
    public function getEbay()
    {
        return $this->ebay;
    }

    /**
     * @return array
     */
    public function getSettings(){
        $vars = get_class_vars(Setting::class);

        $settings = array();

        foreach ($vars as $key => $value){
            $functionName = 'get' . ucfirst($key);
            $value = $this->$functionName();

            if ($key != "id")
                $settings[$key] = $value;
        }

        return $settings;
    }
}

