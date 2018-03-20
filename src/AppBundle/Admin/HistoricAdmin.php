<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 04/03/18
 * Time: 11:55
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Miner;
use AppBundle\Entity\Traits\UnitTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class HistoricAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('objectClassName')
            ->add('value')
            ->add('unit')
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('objectClassName')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('objectClassName')
            ->add('value')
            ->add('unit')
        ;
    }
}
