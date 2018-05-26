<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BlogentrieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, ['label'=>"Título",'attr' =>['data-time-picker'=>'']])
            ->add('teaser', null, ['label'=>"Resumen o Subtítulo"])
            ->add('posttext')
            ->add('publisheddate', null, ['label'=>"Fecha de Publicación"] )
            ->add('picture', null,['label'=>"Imagen destacada"] )
            ->add('secondaryPicture',null,['label'=>"Imagen secundaria"])
            ->add('tags', CollectionType::class, [
                'entry_type'=>TagType::class ,
                'allow_add'=> true,
                'by_reference' => false,
                'allow_delete' => true,
                ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Blogentrie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_blogentries';
    }


}
