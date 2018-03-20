<?php

namespace AppBundle\Controller;

use Endroid\Twitter\Twitter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("alert")
 */
class AlertController extends Controller
{
    /**
     * @Route("/", name="alert_dashboard")
     */
    public function indexAction(Request $request)
    {
        $alerts = $this->getDoctrine()->getRepository('AppBundle:Alert\TwitterAlert')->findAll();

        return $this->render('AppBundle:alert:index.html.twig', array(
            "alerts" => $alerts
        ));
    }
}
