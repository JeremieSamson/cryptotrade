<?php

namespace AppBundle\Entity\Alert;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\TimestampableTrait;

/**
 * Alert
 */
abstract class Alert
{
    /**
     * @var string
     *
     * @ORM\Column(name="original_id", type="string")
     */
    protected $originalId;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    protected $value;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    protected $url;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_been_read", type="boolean")
     */
    protected $hasBeenRead = 0;

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Alert
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Alert
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getOriginalId()
    {
        return $this->originalId;
    }

    /**
     * Get string
     *
     * @param $id
     */
    public function setOriginalId($id)
    {
        $this->originalId = $id;
    }

    /**
     * @return bool
     */
    public function isHasBeenRead()
    {
        return $this->hasBeenRead;
    }

    /**
     * @return bool
     */
    public function hasBeenRead()
    {
        return $this->hasBeenRead;
    }

    /**
     * @param bool $hasBeenRead
     */
    public function setHasBeenRead($hasBeenRead)
    {
        $this->hasBeenRead = $hasBeenRead;
    }
}

