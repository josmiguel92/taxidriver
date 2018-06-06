<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PlaceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, ["label"=>"Nombre que se mostrará"])
            ->add('nameEn', null, ["label"=>"Nombre que se mostrará, en ingles"])
            ->add('distance', null, ["label"=>"Distancia, en km."])
            ->add('file', null, ['label'=>"Imágen representativa"])

            ->add('time', null, ["label"=> "Tiempo de recorrido, (horas:minutos)"])
            ->add('price')
            ->add('istour', null, ['label'=>"¿Es un Tour?"])
            ->add('placedesc', null, ['label'=>"Describa el Tour"])
            ->add('placedescen', null, ['label'=>"Describa el Tour, en ingles"])


            //->add('services')
            ->add('latlong',HiddenType::class)
            ->add('googlename',HiddenType::class)
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Place'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_place';
    }


}
