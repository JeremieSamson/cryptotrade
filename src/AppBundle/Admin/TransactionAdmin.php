<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 04/03/18
 * Time: 11:55
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TransactionAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('value')
            ->add('fromAddress')
            ->add('toAddress')
            ->add('timeStamp')
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('value')
            ->add('fromAddress')
            ->add('toAddress')
            ->add('timeStamp')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fromAddress')
            ->add('toAddress')
            ->add('value')
            ->add('timeStamp')
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
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('gpus')
            ->add('supportPrice')
            ->add('owner')
            ->add('ethAddress')
            ->add('ethAddress.fromTransactions')
            ->add('ethAddress.toTransactions')

        ;
    }
}
