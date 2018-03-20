<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 20/03/18
 * Time: 18:51
 */

namespace UserBundle\Form\Type;

use Base\Form\Handler\BaseHandler;

class ProfileHandler extends BaseHandler
{
    /**
     * Process chantier form
     *
     * @return bool
     */
    public function process()
    {
        $this->form->handleRequest($this->request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {

            $this->onSuccess();

            return true;
        }

        return false;
    }

    /**
     * Flush updates and exec new query in temp table
     */
    public function onSuccess()
    {

    }
}