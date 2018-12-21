<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;


class SiteContentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('abouttitle', null, ["label"=> "Título de la sección About"])
            ->add('abouttitleen', null, ["label"=> "Título de la sección About, en ingles"])

            ->add('abouttext', CKEditorType::class, ["label"=>"Texto sobre nosotros"])
            ->add('abouttexten', CKEditorType::class, ["label"=>"Texto sobre nosotros, en ingles"])
            ->add('aboutusimage',null, ["label"=> "Banner para sección About."])
            ->add('aboutteamtext', TextareaType::class, ["label"=>"Texto sobre el equipo"])
            ->add('aboutteamtexten', TextareaType::class, ["label"=>"Texto sobre el equipo, en ingles"])
            ->add('aboutinfographtitle', null,  ["label"=>"Titulo de la Infografía"])
            ->add('aboutinfographtitleen', null,  ["label"=>"Titulo de la Infografía, en ingles"])
            ->add('aboutinfographtext', TextareaType::class, ["label"=>"Texto sobre la Infografía"])
            ->add('aboutinfographtexten', TextareaType::class, ["label"=>"Texto sobre la Infografía, en ingles"])
            ->add('servicestitle', null, ["label"=>"Título de los servicios"])
            ->add('servicestitleen', null, ["label"=>"Título de los servicios, en ingles"])
            ->add('servicestext', CKEditorType::class, ["label"=>"Texto sobre los servicios"])
            ->add('servicestexten', CKEditorType::class, ["label"=>"Texto sobre los servicios, en ingles"])
            ->add('servicestaxititle', null , ["label"=>"Título de los servicios de taxi"])
            ->add('servicestaxititleen', null , ["label"=>"Título de los servicios de taxi, en ingles"])
            ->add('servicestaxitext', CKEditorType::class, ["label"=>"Texto sobre el servicio de Taxi"])
            ->add('servicestaxitexten', CKEditorType::class, ["label"=>"Texto sobre el servicio de Taxi, en ingles"])
            ->add('servicestaxitourstitle', null, ["label"=>"Título del servicio de taxi-tour"])
            ->add('servicestaxitourstitleen', null, ["label"=>"Título del servicio de taxi-tour, en ingles"])
            ->add('servicestaxitourstext', CKEditorType::class, ["label"=>"Texto sobre el servicio de Tour"])
            ->add('servicestaxitourstexten', CKEditorType::class, ["label"=>"Texto sobre el servicio de Tour, en ingles"])

            ->add('airport_transfer_title', null, ["label"=>"Título del servicio de taxi al aeropuerto"])
            ->add('airport_transfer_title_en', null, ["label"=>"Título del servicio de taxi al aeropuerto, ingles"])
            ->add('airport_transfer_text', CKEditorType::class, ["label"=>"Texto sobre el servicio de Taxi al aeropuerto"])
            ->add('airport_transfer_text_en', CKEditorType::class, ["label"=>"Texto sobre el servicio de Taxi al aeropuerto, ingles"])


            ->add('touradvice', TextareaType::class, ["label"=>"Aviso sobre los tours"])
            ->add('touradviceen', TextareaType::class, ["label"=>"Aviso sobre los tours, en ingles"])



            ->add('experiencestext', CKEditorType::class, ["label"=>"Texto sobre las experiencias"])
            ->add('experiencestexten', CKEditorType::class, ["label"=>"Texto sobre las experiencias, en ingles"])
            
            
            ->add('ownrouteimage',null, ["label"=> "Banner para Ruta personalizada."])
            ->add('ownrouteimage1',null, ["label"=> "Banner para Ruta personalizada."])
            ->add('ownrouteimage2',null, ["label"=> "Banner para Ruta personalizada."])

            ->add('servicesmakeroutetext', CKEditorType::class, ["label"=>"Texto para rutas personalizadas, en el home"])
            ->add('servicesmakeroutetexten', CKEditorType::class, ["label"=>"Texto para rutas personalizadas, en el home, en ingles"])

            ->add('owntaxidescription', CKEditorType::class, ["label"=>"Texto describiendo las rutas personalizadas, en la reservacion"])
            ->add('owntaxidescriptionen', CKEditorType::class, ["label"=>"Texto describiendo las rutas personalizadas, en la reservacion, en ingles"])



            ->add('servicesinfographtitle',null, ["label"=>"Título de infografía de servicios"])
            ->add('servicesinfographtitleen',null, ["label"=>"Título de infografía de servicios, en ingles"])
            ->add('contacttelephone', null, ["label"=> "Teléfono de Contacto."])
            ->add('contactemail', null, ["label"=> "Email de Contacto."])
            ->add('contactaddress', null, ["label"=> "Dirección."])
            ->add('contactaddress_en', null, ["label"=> "Dirección, en ingles."])
            ->add('blogimage', null, ["label"=> "Banner para el Header."])

            ->add('sitedescription',null, ["label"=>"Descripción del sitio"])
            ->add('sitedescriptionen',null, ["label"=>"Descripción del sitio, en ingles"])

            ->add('blogdescription',null, ["label"=>"Descripción del blog"])
            ->add('blogdescriptionen',null, ["label"=>"Descripción del blog, en ingles"])

            ->add('reservationdescription',null, ["label"=>"Descripción de las reservaciones"])
            ->add('reservationdescriptionen',null, ["label"=>"Desc. de las reservaciones, en ingles"])

            ->add('sitekeywords',null, ["label"=>"Keywords del sitio"])
            ->add('sitekeywordsen',null, ["label"=>"Keywords del sitio, en ingles"]);


    }

    /**
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
