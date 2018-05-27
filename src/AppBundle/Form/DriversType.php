<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DriversType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fullname')
            ->add('file', null, ['label'=>'Imagen'])
            ->add('enterprisetitle', null, ['label'=>'Puesto'])
            ->add('jobdescription',null, ['label'=>'Descripción del trabajo'])
            ->add('jobdescriptionen', null, ['label'=>'Descripción del trabajo, en ingles']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Drivers'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_drivers';
    }


}
