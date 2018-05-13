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


        $builder->add('logourl', null, ["label"=>"URL del Logo"])
            ->add('abouttitle', null, ["label"=> "Título de la sección About"])
            ->add('abouttitleen', null, ["label"=> "Título de la sección About, en ingles"])

            ->add('abouttext', TextareaType::class, ["label"=>"Texto sobre nosotros"])
            ->add('abouttexten', TextareaType::class, ["label"=>"Texto sobre nosotros, en ingles"])
            ->add('abouttextfooter', TextareaType::class, ["label"=>"Texto sobre nosotros, se mostrará en Footer"])
            ->add('abouttextfooteren', TextareaType::class, ["label"=>"Texto sobre nosotros, se mostrará en Footer, en ingles"])
            ->add('aboutteamtext', TextareaType::class, ["label"=>"Texto sobre el equipo"])
            ->add('aboutteamtexten', TextareaType::class, ["label"=>"Texto sobre el equipo, en ingles"])
            ->add('aboutinfographtitle', null,  ["label"=>"Titulo de la Infografía"])
            ->add('aboutinfographtitleen', null,  ["label"=>"Titulo de la Infografía, en ingles"])
            ->add('aboutinfographtext', TextareaType::class, ["label"=>"Texto sobre la Infografía"])
            ->add('aboutinfographtexten', TextareaType::class, ["label"=>"Texto sobre la Infografía, en ingles"])
            ->add('aboutinfographitems', null, ["label"=>"Elementos de la Infografía sobre nosotros"])
            ->add('servicestitle', null, ["label"=>"Título de los servicios"])
            ->add('servicestitleen', null, ["label"=>"Título de los servicios, en ingles"])
            ->add('servicestext', TextareaType::class, ["label"=>"Texto sobre los servicios"])
            ->add('servicestexten', TextareaType::class, ["label"=>"Texto sobre los servicios, en ingles"])
            ->add('servicestaxititle', null , ["label"=>"Título de los servicios de taxi"])
            ->add('servicestaxititleen', null , ["label"=>"Título de los servicios de taxi, en ingles"])
            ->add('servicestaxitext', TextareaType::class, ["label"=>"Texto sobre el servicio de Taxi"])
            ->add('servicestaxitexten', TextareaType::class, ["label"=>"Texto sobre el servicio de Taxi, en ingles"])
            ->add('servicestaxitourstitle', null, ["label"=>"Título del servicio de taxi-tour"])
            ->add('servicestaxitourstitleen', null, ["label"=>"Título del servicio de taxi-tour, en ingles"])
            ->add('servicestaxitourstext', TextareaType::class, ["label"=>"Texto sobre el servicio de Tour"])
            ->add('servicestaxitourstexten', TextareaType::class, ["label"=>"Texto sobre el servicio de Tour, en ingles"])
            ->add('jsonmaproutes',null, ["label"=>"Datos del Mapa, en formato JSON"])
            ->add('servicesmakeroutetext', TextareaType::class, ["label"=>"Texto para rutas personalizadas"])
            ->add('servicesmakeroutetexten', TextareaType::class, ["label"=>"Texto para rutas personalizadas, en ingles"])
            ->add('servicesotherinfographitems', null, ["label"=>"Elementos de la Infografía de servicios"])
            ->add('contacttelephone', null, ["label"=> "Teléfono de Contacto."])
            ->add('contactemail', null, ["label"=> "Email de Contacto."]);
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
