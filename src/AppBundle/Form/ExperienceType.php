<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExperienceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, ["label"=>"Nombre de la experiencia"])
            ->add('nameEn', null, ["label"=>"Nombre de la experiencia, en ingles"])
            ->add('place', null, ["label"=>"Lugar"])
            ->add('placeEn', null, ["label"=>"Lugar, en ingles"])
            ->add('price', null, ["label"=>"Precio de la experiencia"])
            ->add('priceEn', null, ["label"=>"Precio de la experiencia en ingles"])
            ->add('priceSumary', null, ["label"=>"Precios segun el origen"])
            ->add('priceSumaryEn', null, ["label"=>"Precios segun origen, en ingles"])
            ->add('description', null, ["label"=>"Derscripcion"])
            ->add('descriptionEn', null, ["label"=>"Descripcion, en ingles"])
            ->add('external', null, ["label"=>"Esta experiencia se gestiona desde otra web"])
            ->add('externalUrl', null, ["label"=>"URL Externa para gestionar la experiencia"])
            ->add('needTaxi', null, ["label"=>"¿Es necesario transporte por taxi para esta experiencia?"])
            ->add('file', null, ['label'=>"Imagen de la Experiencia"]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Experience'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_experience';
    }


}
