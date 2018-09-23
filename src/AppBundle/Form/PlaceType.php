<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PlaceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('origin', null, ["label"=>"Origen, si no se establece, se mostrará La Habana"])
            ->add('originEn', null, ["label"=>"Origen, en ingles, opcional"])
            ->add('name', null, ["label"=>"Destino"])
            ->add('nameEn', null, ["label"=>"Destino, en ingles"])
            ->add('distance', null, ["label"=>"Distancia, en km."])

            ->add('time', null, ["label"=> "Tiempo de recorrido, (horas:minutos)"])
            ->add('price', MoneyType::class, ["label"=>"Precio minimo del Tour",'currency'=>"CUC"])
            ->add('trasferprice', MoneyType::class, ["label"=>"Precio minimo del Transfer",'currency'=>"CUC"])
            ->add('istour', null, ['label'=>"¿Es un Tour?"])
            ->add('placedesc', null, ['label'=>"Describa el Tour"])
            ->add('placedescen', null, ['label'=>"Describa el Tour, en ingles"])

            //->add('services')
            ->add('latlong',HiddenType::class)
            ->add('googlename',HiddenType::class)

            ->add('file', null, ['label'=>"Imágen representativa"])

            ->add('galleryImage0',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage1',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage2',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage3',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage4',null,['label'=>"Agregar una imagen"])

            ->add('weight',null,['label'=>"Peso del Servicio, mayores numeros apareceran primero"])

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
