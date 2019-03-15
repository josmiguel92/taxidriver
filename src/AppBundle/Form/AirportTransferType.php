<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use FOS\CKEditorBundle\Form\Type\CKEditorType;

class AirportTransferType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameEs', null, ["label"=>"Nombre del Transfer"])
            ->add('name', null, ["label"=>"Nombre del Transfer, en ingles"])
            ->add('targetAirport', null, ['label'=> "Aeropuerto de origen/destino"])

            ->add('basePrice', MoneyType::class, ["label"=>"Precio base del recorrido",'currency'=>"USD"])

            ->add('description',CKEditorType::class, ["label"=>"Descripción, en español"])
            ->add('descriptionEn', CKEditorType::class, ["label"=>"Descripción, en ingles"])

            ->add('file', null, ['label'=>"Imagen destacada del transfer"])

            ->add('targetPlace')
            ->add('weight', null, ['label'=>'Orden entre los servicios'])
            ->add('isExternalBook', CheckboxType::class , ['label'=>'Este servicio se reserva en otra web', 'required'=>false])
            ->add('externalEmb', TextareaType::class, ['label'=>'Código HTML a insertar para reservar, incluye enlace [Español]'])
            ->add('externalEmbEn', TextareaType::class, ['label'=>'Código HTML a insertar para reservar, incluye enlace [Ingles]'])
        ;
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
