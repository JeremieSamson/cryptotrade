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

class MinerAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('hashrate')
            ->add('unit', 'choice', array(
                'choices' => UnitTrait::$units
            ))
            ->add('watt')
            ->add('provider')
            ->add('url')
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('getHashrateWithUnite', null, array('label' => 'admin.miner.list.hashrate_unite'))
            ->add('watt')
            ->add('provider')
        ;
    }
}
