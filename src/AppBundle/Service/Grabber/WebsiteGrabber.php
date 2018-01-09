<?php

namespace AppBundle\Service\Grabber;

/**
 * Class WebsiteGrabber
 */
class WebsiteGrabber
{
    public function parse($url){
        $dom = new \DOMDocument();
        $dom->loadHTML($this->getHtml($url));

        return $dom->getElementsByTagName("main_body");
    }

    public function getHtml($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        return $server_output;
    }
}