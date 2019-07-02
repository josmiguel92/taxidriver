<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use FOS\CKEditorBundle\Form\Type\CKEditorType;

class TransferType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameEs', null, ["label"=>"Nombre del transfer"])
            ->add('name', null, ["label"=>"Nombre del transfer, en ingles"])

            ->add('targetPlace', null, ["label"=>"Lugar de destino"])

            ->add('origin', null, ["label"=>"Lugar de origen (opcional)"])
            ->add('distance', null, ["label"=>"Distancia, en km"])

            ->add('priceSumary', null, ["label"=>"Precios segun origen"])
            ->add('priceSumaryEn', null, ["label"=>"Precios segun el origen, en ingles"])

            ->add('basePrice', MoneyType::class, ["label"=>"Precio del transfer",'currency'=>"EUR"])

            ->add('description', CKEditorType::class, ["label"=>"Descripcion, en español"])
            ->add('descriptionEn',CKEditorType::class, ["label"=>"Descripcion, en ingles"])

            ->add('file', null, ['label'=>"Imagen destacada del transfer"])
            ->add('weight', null, ['label'=>'Orden entre los servicios, mayores tienen prioridad'])
            ->add('important', null, ['label'=>'Destacado, aparece en las sugerencias'])

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
            'data_class' => 'AppBundle\Entity\Transfer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_transfer';
    }


}
