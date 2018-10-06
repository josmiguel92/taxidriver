<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('airport')
            ->add('place')
            ->add('ownroute')
            ->add('tour')
            ->add('fullname')
            ->add('email', EmailType::class)
            ->add('flynumber')
            ->add('details')
            ->add('pickuptime', TextType::class)
            ->add('numpeople',IntegerType::class)
            ->add('comment')
            ->add('returnpickupplacce')
            ->add('returnpickup')
            ->add('returnpickuptime',TextType::class)
            ->add('experience')
            ->add('experienceTaxi')
            ->add('experienceTime')
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
