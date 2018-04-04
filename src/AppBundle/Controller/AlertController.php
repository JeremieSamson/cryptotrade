<?php

namespace AppBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
        $alerts = array();

        // Add Twitter Alert
        array_merge($alerts, $this->getDoctrine()->getRepository('AppBundle:Alert\TwitterAlert')->findAll());

        // Add user transaction Alert


        return $this->render('AppBundle:alert:index.html.twig', array(
            "alerts" => $alerts
        ));
    }

    /**
     * @Route("/{id}", name="alert_view")
     * @ParamConverter("alert", class="AppBundle\Entity\Alert\Alert")
     */
    public function viewAction(Request $request, $alert)
    {
        return $this->render('AppBundle:alert:index.html.twig', array(
            "alert" => $alert
        ));
    }
}
