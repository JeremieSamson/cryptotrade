<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * Trait UnitTrait
 */
trait UnitTrait
{
    public static $units = array(
        '' => 1,
        'K' => 1000,
        'M' => 1000000,
        'G' => 1000000000,
        'T' => 1000000000000,
        'P' => 1000000000000000,
        'E' => 1000000000000000000,
        'Z' => 1000000000000000000000,
        'Y' => 1000000000000000000000000
    );

    /**
     * Unite
     *
     * @var string
     *
     * @ORM\Column(name="unit", type="bigint")
     */
    private $unit;

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @param $unit
     *
     * @return string
     */
    public function getUnitToString($unit){
        return self::$units[$unit];
    }
}