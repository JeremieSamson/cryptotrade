<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 20/03/18
 * Time: 19:04
 */

namespace Base\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class BaseHandler
{
    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var FormInterface $form
     */
    protected $form;

    /**
     * BaseHandler constructor.
     *
     * @param Request $request
     * @param FormInterface $form
     */
    public function __construct(Request $request, FormInterface $form)
    {
        $this->request = $request;
        $this->form = $form;
    }
}