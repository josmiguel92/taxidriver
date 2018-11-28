<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirportTransferType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameEs', null, ["label"=>"Nombre de la experiencia"])
            ->add('name', null, ["label"=>"Nombre de la experiencia, en ingles"])

            ->add('basePrice', null, ["label"=>"Precio base del recorrido"])

            ->add('descriptionEs',CKEditorType::class, ["label"=>"Descripción, en español"])
            ->add('description', CKEditorType::class, ["label"=>"Descripción, en ingles"])


            ->add('file', null, ['label'=>"Imagen destacada de la Experiencia"])

            ->add('targetAirport')
            ->add('targetPlace');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AirportTransfer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_airporttransfer';
    }


}
