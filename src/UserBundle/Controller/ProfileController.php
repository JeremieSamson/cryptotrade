<?php

namespace UserBundle\Controller;

use Base\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Model\Profile;
use UserBundle\Form\Type\ProfileHandler;
use UserBundle\Form\Type\ProfileType;

/**
 * @Route("profile")
 */
class ProfileController extends BaseController
{
    /**
     * @Route("/", name="profile")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(ProfileType::class, null, array());
        $formHandler = new ProfileHandler($request, $form);

        if ($formHandler->process()) {

        }

        $this->checkSubmitted($form);

        return $this->render('UserBundle:profile:index.html.twig', array(
            "form" => $form
        ));
    }
}
