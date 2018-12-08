<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TestimonyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('file', null,['label'=>"Imagen del perfil"] )
            ->add('text', TextareaType::class, ['label'=>'Comentario'])
            ->add('texten', TextareaType::class, ['label'=>'Comentario, en ingles'])
            ->add('link', null, ['label'=>'Enlace a la pag. web del comentario'])
            ->add('points', null, ['label'=>'Puntuacion [1-5]'])
        ->add('targetPlace',null, ['label'=>'Lugar sobre el que habla'] )
        ->add('experience',null, ['label'=>'Experiencia sobre la que habla'])
        ->add('transfer',null, ['label'=>'Transfer sobre el que habla']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Testimony'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_testimony';
    }


}
