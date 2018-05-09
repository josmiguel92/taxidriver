<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ["label"=>"Título de la imagen (español)"])
            ->add('details_es', null, ["label"=>"Describa la imagen (español)"])
            ->add('title_en', null, ["label"=>"Título de la imagen (ingles)"])
            ->add('details_en', null, ["label"=>"Describa la imagen (ingles)"])
            ->add('file', null, ["label"=>"Archivo de Imagen"])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Image'
        ));
    }
}
