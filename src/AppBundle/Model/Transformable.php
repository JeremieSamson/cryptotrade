<?php

namespace AppBundle\Model;

/**
 * Class Transformable
 */
abstract class Transformable
{
    /**
     * Init Class
     *
     * @param $datas
     */
    public function set($datas) {
        foreach ($datas AS $key => $value) {
            if ($value) {
                $this->{"set" . ucfirst($key)} = $value;
            }
        }
    }
}