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

use Symfony\Component\Form\Extension\Core\Type\TextType;


class FullBookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('bookingTime', DateTimeType::class, ['label'=>'Fecha de Reservacion'])
            ->add('airport',null, ['label'=>"Aeropuerto"])
            ->add('place',null, ['label'=>"Lugar"])
            ->add('tour')
            ->add('fullname',null, ['label'=>'Nombre'])
            ->add('email', EmailType::class, ['label'=>'Correo electronico'])
            ->add('telephone', null, ['label'=>'Telefono del Cliente'])
            ->add('flynumber',null, ['label'=>'# Vuelo'])
            ->add('details',null, ['label'=>'Lugar de Recogida'])
            ->add('pickuptime', TextType::class, ['label'=>'Fecha/Hora Recogida'])
            ->add('returnpickup', null, ['label'=>'Recogida'])
            ->add('experienceTaxi',null, ['label'=>'Taxi para Experiencia'])
            ->add('experienceTime', null, ['label'=>'Tiempo en la Experiencia'])
            ->add('toAirport', null, ['label'=>'Ida al Aeropuerto'])
            ->add('timelinetravel', null, ['label'=>'Viajes Intermedios'])
            ->add('children',null, ['label'=>'Niños'])
            ->add('bookingLanguage', null, ['label'=>'Idioma'])
            ->add('paymentDetails', null, ['label'=>'Detalles de Pago'])
            ->add('drivername', null, ['label'=>'Nombre del Chofer'])
            ->add('drivertelephone', null, ['label'=>'Teléfono del Chofer'])
            ->add('returnpickuptime',TextType::class, ['label'=>'Fecha/Hora de Recogida al regreso'])
            ->add('returnpickupplacce', null, ['label'=>'Lugar de recogida al Regreso'])
            ->add('numpeople',IntegerType::class, ['label'=>'Cantidad de Personas'])
            ->add('price', null, ['label'=>'Precio'])
            ->add('comment', null, ['label'=>'Comentarios del Cliente'])
            ->add('accepted',CheckboxType::class, ['label'=>'Aceptada por la Administración'])
            ->add('confirmed', CheckboxType::class,['label'=>'Confirmada por la Administración'])
            ->add('drivermsg', null, ['label'=>'Mensaje enviado al cliente al definir el precio'])

            ->add('serviceType', ChoiceType::class, ['choices'=>[['Experience'=>'Experience'],
                                                                    ['Transfer'=>'Transfer'],['AirportTransfer'=>'AirportTransfer']]])
            ->add('airportName', null, ['label'=>'Aeropuerto vinculado'])
            ->add('targetPlace', null, ['label'=>'Lugar de Destino'])
            ->add('airportTransfer', null, ['label'=>'TransferAeropuerto vinculado'])
            ->add('experience', null, ['label'=>'Experiencia vinculada'])
            ->add('transfer', null, ['label'=>'Transfer vinculado']);
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
