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
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class EbaySellAdmin extends AbstractAdmin
{
    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('miner')
            ->add('price')
            ->add('unite')
            ->add('url')
            ->add('updatedAt')
            ->add('createdAt')
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('price')
            ->add('unit')
            ->add('miner')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('miner')
            ->add('price')
            ->add('unit')
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'show' => array(),
                        'delete' => array()
                    )
                )
            );
        ;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('edit');
        $collection->remove('create');
        $collection->remove('add');
    }
}
