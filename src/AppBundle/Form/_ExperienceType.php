<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ExperienceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, ["label"=>"Nombre de la experiencia"])
            ->add('nameEn', null, ["label"=>"Nombre de la experiencia, en ingles"])
            ->add('place')
            ->add('placeEn', null, ["label"=>"Lugar, en ingles"])
            ->add('price', null, ["label"=>"Precio de la experiencia"])
            ->add('priceEn', null, ["label"=>"Precio de la experiencia en ingles"])
            ->add('priceSumary')
            ->add('priceSumaryEn')
            ->add('description', CKEditorType::class, ["label"=>"Descripcion"])
            ->add('descriptionEn', )
            ->add('external', null, ["label"=>"Esta experiencia se gestiona desde otra web"])
            ->add('externalUrl', null, ["label"=>"URL Externa para gestionar la experiencia"])
            ->add('needTaxi', null, ["label"=>"¿Es necesario transporte por taxi para esta experiencia?", "attr"=>["checked"=>"true"]])
            ->add('galleryImage0',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage1',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage2',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage3',null,['label'=>"Agregar una imagen"])
            ->add('galleryImage4',null,['label'=>"Agregar una imagen"]);
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
