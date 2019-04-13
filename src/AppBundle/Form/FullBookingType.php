<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\TextType;


class FullBookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pickuptime', DateTimeType::class, ['label'=>'Fecha/Hora Recogida'])

            ->add('fullname',null, ['label'=>'Nombre del Cliente'])

            ->add('airport',
            ChoiceType::class, ['choices'=>['Otro'=>'Otro','Aeropuerto'=>'airport',
                'Crucero'=>'cruise'],'label'=>"Lugar de Recogida"])

            ->add('details',null, ['label'=>'Lugar de Recogida (detalles)'])
            ->add('flynumber',null, ['label'=>'Número Vuelo o Nombre del Crucero'])
            ->add('airportName', null, ['label'=>'Aeropuerto de arribo'])

//            ->add('place',null, ['label'=>"Lugar"])
             ->add('email', EmailType::class, ['label'=>'Correo electrónico'])
            ->add('telephone', null, ['label'=>'Teléfono del Cliente'])
            ->add('returnpickup', null, ['label'=>'Viaje de regreso'])
            ->add('experienceTaxi',null, ['label'=>'Taxi para Experiencia'])
            ->add('experienceTime', null, ['label'=>'Tiempo en la Experiencia'])
//            ->add('toAirport', null, ['label'=>'Ida al Aeropuerto'])
            ->add('timelinetravel', null, ['label'=>'Varios lugares de destino'])
            ->add('children',null, ['label'=>'Incluyen niños'])
            ->add('bookingLanguage', null, ['label'=>'Idioma'])
            ->add('payed', null, ['label'=> "El pago fue realizado con exito"])
            ->add('payedDate',  DateType::class, ['widget'=>'single_text','label'=> "Fecha en que se realiza el pago"])

            ->add('paymentDetails', null, ['label'=>'Detalles de Pago'])
            ->add('drivername', null, ['label'=>'Datos de contacto del Chofer'])
//            ->add('drivertelephone', null, ['label'=>'Teléfono del Chofer'])
            ->add('returnpickuptime',DateTimeType::class, ['label'=>'Fecha/Hora de Recogida al regreso', 'required'=>false])
            ->add('returnpickupplacce', null, ['label'=>'Lugar de recogida al Regreso'])
            ->add('numpeople',IntegerType::class, ['label'=>'Cantidad de Personas'])
            ->add('price', null, ['label'=>'Precio'])
            ->add('comment', null, ['label'=>'Comentarios del Cliente'])
            ->add('accepted',CheckboxType::class, ['label'=>'Aceptada por la Administración', 'required'=>false])
            ->add('confirmed', CheckboxType::class,['label'=>'Confirmada por la Administración', 'required'=>false])
            //->add('drivermsg', null, ['label'=>'Mensaje enviado al cliente al definir el precio'])

            ->add('serviceType', ChoiceType::class, ['label'=>'Tipo de Servicio','choices'=>['Transfer'=>'Transfer','Experience'=>'Experience', 'AirportTransfer'=>'AirportTransfer']])
            ->add('bookingSource', ChoiceType::class, ['label'=>'Origen de la Reserva',
                                    'choices'=>['Formulario Web Taxidrivers'=>'webtaxidrivers',
                                                'Emails'=>'email',
                                                'Redes Sociales'=>'social',
                                                'Otro'=>'other']])
            ->add('targetPlace', null, ['label'=>'Lugar de Destino'])
//            ->add('airportTransfer', null, ['label'=>'TransferAeropuerto vinculado'])
            ->add('experience', null, ['label'=>'Tipo de Experiencia'])
//            ->add('transfer', null, ['label'=>'Transfer vinculado'])
;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Booking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_booking';
    }


}
