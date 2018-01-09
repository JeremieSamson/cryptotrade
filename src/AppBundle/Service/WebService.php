<?php

namespace AppBundle\Service;

/**
 * Class WebService
 */
class WebService
{
    private $baseUrl;

    /**
     * @param $baseUrl
     */
    public function setBaseUrl($baseUrl){
        $this->baseUrl = $baseUrl;
    }

    /**
     * Perform a get on a specific URL
     *
     * @param null $route
     *
     * @return array
     */
    protected function get($route = null){
        $url = $this->baseUrl . ($route ? '/' . $route : '');
        $json = file_get_contents($url);
        $obj = json_decode($json, true);

        return $obj;
    }

    /**
     * Transform json to class
     */
    protected function transform($data, $class){
        foreach($data as $key => $val)
        {
            if(property_exists($class,$key))
            {
                $class->$key =  $val;
            }
        }
    }
}