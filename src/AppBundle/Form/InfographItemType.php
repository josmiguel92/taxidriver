<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfographItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, ['label'=>"Titulo"])
            ->add('title_en', null,  ['label'=>"Titulo, en ingles"])

            ->add('text', null, ['label'=>"Texto"])
            ->add('text_en', null,  ['label'=>"Texto, en ingles"])
            ->add('icon', null, ['label'=>'Icono'])
        ->add('isservices', null, ['label'=>'Es infografía de servicios']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\InfographItem'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_infographitem';
    }


}
