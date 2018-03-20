<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 20/03/18
 * Time: 19:11
 */

namespace Base\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

abstract class BaseController extends Controller
{
    /**
     * @param FormInterface $form
     */
    public function checkSubmitted(FormInterface $form){
        if (!$form->isSubmitted()) {
            $form->addError(new FormError($this->trans('error.submitted')));
        }
    }
}