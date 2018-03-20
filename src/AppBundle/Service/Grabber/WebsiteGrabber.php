<?php

namespace AppBundle\Service\Grabber;

/**
 * Class WebsiteGrabber
 */
class WebsiteGrabber
{
    /**
     * @param $url
     * @param $tagName
     * @param $className
     *
     * @return \DOMElement|null
     */
    public function getElementsByClassName($url, $tagName, $className){
        $dom = $this->getDomDocument($url);

        if ($dom) {
            $xpath = new \DOMXpath($dom);
            $tags = $xpath->query("//" . $tagName . "[@class=\"$className\"]");

            return $tags->item(0);
        } else {
            var_dump("pas dom");
        }

        return null;
    }

    /**
     * @param $url
     * @return \DOMDocument|null
     */
    public function getDomDocument($url){
        $dom = new \DOMDocument();

        $internalErrors = libxml_use_internal_errors(true);

        try {
            $dom->loadHTML($this->getHtml($url));
        }catch (\Exception $exception){
            $dom = null;
        }

        libxml_use_internal_errors($internalErrors);

        return $dom;
    }

    /**
     * @param $url
     * @return mixed
     */
    private function getHtml($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        return $server_output;
    }
}