<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

            ->add('priceSumary', null, ["label"=>"Precios segun origen"])
            ->add('priceSumaryEn', null, ["label"=>"Precios segun el origen, en ingles"])

            ->add('basePrice', null, ["label"=>"Precio del transfer"])

            ->add('description', CKEditorType::class, ["label"=>"Descripcion, en español"])
            ->add('descriptionEn',CKEditorType::class, ["label"=>"Descripcion, en ingles"])

            ->add('file', null, ['label'=>"Imagen destacada del transfer"])
            ->add('weight', null, ['label'=>'Orden entre los servicios'])
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
