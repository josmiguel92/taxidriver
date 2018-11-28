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
        $builder
            ->add('nameEs', null, ["label"=>"Nombre de la experiencia"])
            ->add('name', null, ["label"=>"Nombre de la experiencia, en ingles"])

            ->add('priceSumary', null, ["label"=>"Precios segun origen"])
            ->add('priceSumaryEn', null, ["label"=>"Precios segun el origen, en ingles"])

            ->add('external', null, ["label"=>"Esta experiencia se gestiona desde otra web"])
            ->add('externalUrl', null, ["label"=>"URL Externa para gestionar la experiencia"])

            ->add('basePrice', null, ["label"=>"Precio de la experiencia"])

            ->add('description', CKEditorType::class, ["label"=>"Descripcion, en español"])
            ->add('descriptionEn',CKEditorType::class, ["label"=>"Descripcion, en ingles"])

            ->add('file', null, ['label'=>"Imagen destacada de la Experiencia"])

            ->add('targetPlace', null, ["label"=>"Lugar donde se realiza"])
            ->add('galleryImage0')->add('galleryImage1')->add('galleryImage2')
            ->add('galleryImage3')->add('galleryImage4');
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
