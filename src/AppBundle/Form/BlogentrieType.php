<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class BlogentrieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, ['label'=>"Título",'attr'=>['reflang'=>'es']])
            ->add('titleen', null, ['label'=>"Título, en ingles",'attr'=>['reflang'=>'en']])
            ->add('teaser', CKEditorType::class, ['label'=>"Primera parte del texto",'attr'=>['reflang'=>'es']])
            ->add('teaseren', CKEditorType::class, ['label'=>"Primera parte del texto, en ingles",'attr'=>['reflang'=>'en']])
            ->add('posttext',CKEditorType::class, ['label'=>'Segunda parte del texto','attr'=>['reflang'=>'es']])
            ->add('posttexten',CKEditorType::class, ['label'=>'Segunda parte del texto','attr'=>['reflang'=>'en']])
            ->add('publisheddate', null, ['label'=>"Fecha de Publicación"] )
            ->add('file', null,['label'=>"Imagen destacada"] )
            ->add('secondaryPicture',null,['label'=>"Imagen secundaria, de la galería"])
            ->add('quote',null,['label'=>"Cita destacada",'attr'=>['reflang'=>'es']])
            ->add('quoteen',null,['label'=>"Cita destacada, en ingles",'attr'=>['reflang'=>'en']])
            ->add('place',null,['label'=>"Destino a reservar"])
            ->add('likes')
            ->add('weight',null,['label'=>"Peso del Post, mayores numeros apareceran primero"])
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
