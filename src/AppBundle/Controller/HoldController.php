<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("hold")
 */
class HoldController extends Controller
{
    /**
     * @Route("/", name="hold_dashboard")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:hold:index.html.twig', array(
            "holdings" => $this->getUser()->getHoldings()
        ));
    }
}
