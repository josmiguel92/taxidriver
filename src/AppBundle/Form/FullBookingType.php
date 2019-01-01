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
        $builder->add('bookingTime', DateTimeType::class)
            ->add('airport')
            ->add('place')
            ->add('ownroute')
            ->add('tour')
            ->add('fullname')
            ->add('email', EmailType::class)
            ->add('flynumber')
            ->add('details')
            ->add('pickuptime', TextType::class)
            ->add('returnpickup')
            ->add('experienceTaxi')
            ->add('experienceTime')
            ->add('toAirport')
            ->add('timelinetravel')
            ->add('children')
            ->add('bookingLanguage')
            ->add('paymentDetails')
            ->add('drivername')
            ->add('drivertelephone')
            ->add('returnpickuptime',TextType::class)
            ->add('returnpickupplacce')
            ->add('numpeople',IntegerType::class)
            ->add('price')
            ->add('comment')
            ->add('accepted',CheckboxType::class)
            ->add('confirmed', CheckboxType::class)
            ->add('idpaypal')
            ->add('token')
            ->add('drivermsg')
            ->add('telephone')
            ->add('serviceType', ChoiceType::class, ['choices'=>['Experience', 'Transfer','AirportTransfer']])
            ->add('airportName')
            ->add('targetPlace')
            ->add('airportTransfer')
            ->add('experience')
            ->add('transfer');
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
