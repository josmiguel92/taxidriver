<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SiteContentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('logourl')
            ->add('abouttitle')
            ->add('abouttext', TextareaType::class, ["label"=>"Texto sobre nosotros"])
            ->add('abouttextfooter', TextareaType::class, ["label"=>"Texto sobre nosotros, se mostrará en Footer"])
            ->add('aboutteamtext', TextareaType::class, ["label"=>"Texto sobre el equipo"])
            ->add('aboutinfographtitle')
            ->add('aboutinfographtext', TextareaType::class, ["label"=>"Texto sobre la Infografía"])
            ->add('aboutinfographitems')
            ->add('servicestitle')
            ->add('servicestext', TextareaType::class, ["label"=>"Texto sobre los servicios"])
            ->add('servicestaxititle')
            ->add('servicestaxitext', TextareaType::class, ["label"=>"Texto sobre el servicio de Taxi"])
            ->add('servicestaxitourstitle')
            ->add('servicestaxitourstext', TextareaType::class, ["label"=>"Texto sobre el servicio de Tour"])
            ->add('jsonmaproutes')
            ->add('servicesmakeroutetext', TextareaType::class, ["label"=>"Texto para rutas personalizadas"])
            ->add('servicesotherinfographitems')
            ->add('contacttelephone')
            ->add('contactemail');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SiteContent'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_sitecontent';
    }


}
