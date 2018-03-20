<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Miner;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     */
    public function indexAction(Request $request)
    {
        $cpt = 0;

        $services = array();

        foreach ($this->getUser()->getSetting()->getSettings() as $settingName => $activated){
            if ($activated) {
                if ($settingName == "ebay") {
                    $services[$settingName] = array();

                    $miners = $this->getDoctrine()->getRepository("AppBundle:Miner")->findBy(array("name" => "Antminer S9"));

                    /** @var Miner $miner */
                    foreach($miners as $miner) {
                        $keywords = str_replace(' ', '+', strtolower($miner->getName()));
                        $domDocument = $this->get('global.websitegrabber')->getDomDocument("https://www.ebay.fr/sch/i.html?_from=R40&_sacat=0&LH_BIN=1&_sop=15&_nkw=$keywords&_ipg=200&rt=nc");
                        $domElement = $domDocument->getElementById("ListViewInner");

                        $blacklistWords = array("ebit", "whatsminer");

                        /** @var \DOMElement $nodeDomElement */
                        foreach ($domElement->childNodes as $nodeDomElement){
                            if ($nodeDomElement->childNodes) {
                                /** @var \DOMNodeList $title */
                                $title = $nodeDomElement->getElementsByTagName("h3");

                                /** @var \DOMElement $h3 */
                                $h3 = $title->item(0);

                                /** @var \DOMNodeList $aInH3 */
                                $aInH3 = $h3->getElementsByTagName("a");

                                $titleString = $aInH3->item(0)->getAttribute("title");
                                $titleString = substr($titleString, strlen("Cliquez sur ce lien pour l'afficher "), strlen($titleString));

                                $hasToBeBlacklisted = false;
                                foreach ($blacklistWords as $word){
                                    if (strpos(strtolower($titleString), $word) !== false)
                                        $hasToBeBlacklisted = true;
                                }

                                if ($hasToBeBlacklisted)
                                    continue;

                                $li = $nodeDomElement->getElementsByTagName("li")->item(0);
                                $span = $li->getElementsByTagName("span")->item(0);
                                $price = trim($span->nodeValue);
                                $price = substr($price, 0, strpos($price, ' EUR'));
                                $price = htmlentities($price, null, 'utf-8');
                                $price = str_replace('&Acirc;', '', $price);
                                $sellPrice = intval(str_replace('&nbsp;', '', $price));

                                if ($sellPrice > 1000) {
                                    $services[$settingName][] = $titleString . " => " . $sellPrice . '€';
                                    $cpt++;

                                    if ($cpt == 5) break;
                                }
                            }
                        }
                    }
                }
            }
        }

        // replace this example code with whatever you need
        return $this->render('AppBundle:dashboard:index.html.twig', array(
            'services' => $services
        ));
    }
}
