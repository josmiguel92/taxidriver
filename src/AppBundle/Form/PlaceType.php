<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;


class PlaceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

          ->add('name', null, ["label"=>"Destino"])
            ->add('nameEn', null, ["label"=>"Destino, en ingles"])
            ->add('price', MoneyType::class, ["label"=>"Precio del Tour",'currency'=>"CUC"])
            ->add('trasferprice', MoneyType::class, ["label"=>"Precio del Transfer",'currency'=>"CUC"])
            ->add('istour', null, ['label'=>"¿Es un Tour?"])
            ->add('placedesc', CKEditorType::class, ['label'=>"Describa el Tour"])
            ->add('placedescen', CKEditorType::class, ['label'=>"Describa el Tour, en ingles"])

            //->add('services')
             ->add('googlename',HiddenType::class)

            ->add('file', null, ['label'=>"Imágen representativa"])

            ->add('galleryImage0',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage1',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage2',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage3',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage4',null,['label'=>"Agregar una imagen"])

            ->add('weight',null,['label'=>"Posición/Peso del Servicio, mayores numeros apareceran primero"])

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
