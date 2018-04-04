<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * Trait AlertableTrait
 */
trait AlertableTrait
{
    /**
     * has been read or note
     *
     * @var bool
     *
     * @ORM\Column(name="has_been_read", type="boolean")
     */
    private $hasBeenRead = false;

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