<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 20/03/18
 * Time: 18:51
 */

namespace UserBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends FormType
{
    /**
     * Build the form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('plainPassword')
        ;
    }

    /**
     * Configure form options
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'validation_groups' => array('profile'),
                'data_class' => 'UserBundle\Form\Model\Profile',
            )
        );
    }

    /**
     * Get the form name
     *
     * @return string
     */
    public function getName()
    {
        return 'form_profile';
    }
}