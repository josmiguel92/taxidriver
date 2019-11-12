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

            ->add('basePrice', MoneyType::class, ["label"=>"Precio base del recorrido",'currency'=>"EUR"])
            ->add('is_personal_price', null, ["label"=>"El precio del servicio se cuenta por persona de forma independiente"])
            ->add('personal_price_increment', MoneyType::class, ["label"=>"Incremento del precio por cada persona, independiente de la configuración general",'currency'=>"EUR"])


            ->add('description',CKEditorType::class, ["label"=>"Descripción, en español"])
            ->add('descriptionEn', CKEditorType::class, ["label"=>"Descripción, en ingles"])

            ->add('file', null, ['label'=>"Imagen destacada del transfer"])

            ->add('targetPlace')
            ->add('weight', null, ['label'=>'Orden entre los servicios'])
            ->add('isExternalBook', CheckboxType::class , ['label'=>'Este servicio se reserva en otra web', 'required'=>false])

            ->add('trekksoftId', null, ['label'=>'ID en trekksoft. Ejemplo: si ve algo como id="trekksoft_3234", la ID sería 3234'])
            ->add('trekksoftTourId', null, ['label'=>'ID de tour en trekksoft. Ejemplo: si ve algo como .setAttrib("tourId", "254469"), la ID del tour sería 254469','required'=>false])
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
