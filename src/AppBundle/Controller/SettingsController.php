<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 04/03/18
 * Time: 10:44
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Setting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SettingsController
 *
 * @package UserBundle
 *
 * @Route(path="settings")
 */
class SettingsController extends Controller
{
    /**
     * @Route(path="/", name="settings")
     */
    public function index(){
        return $this->render('AppBundle:settings:index.html.twig', array());
    }

    /**
     * @Route(path="/toogle/{attribute}/{value}", name="settings_dashboard_toogle")
     *
     * @return JSONResponse
     */
    public function toogle($attribute, $value){
        /** @var Setting $setting */
        $setting = $this->getUser()->getSetting();
        $status = "KO";

        $method = 'set' . ucfirst($attribute);
        if (method_exists($setting, $method) && is_callable(array($setting, $method))){
            $setting->$method($value == "true" ? true : false);
            $status = "OK";

            $this->getDoctrine()->getManager()->flush();
        }

        return new JsonResponse(array("status" => $status));
    }
}