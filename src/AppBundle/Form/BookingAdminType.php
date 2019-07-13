<?php

namespace AppBundle\Form;

use AppBundle\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookingAdminType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $booking = $options['data'];
        $builder
            ->add('price', MoneyType::class, ['attr'=>['required'=>'true'], 'currency'=>"EUR"])
            ->add('currency',  ChoiceType::class,
                [
                    'choices' =>
                        [
                            'EUR' => 'EUR',
                            'USD' => 'USD',
                            'CUC' => 'CUC',
                        ],
                    'choice_attr' => [
                        'EUR' => ['data-change' => $booking->getChangeRate('EUR')],
                        'USD' => ['data-change' => $booking->getChangeRate('USD')],
                        'CUC' => ['data-change' => $booking->getChangeRate('CUC')],
                    ],
                    'attr' => ['class'=>'currency_select'],

                    'label' => 'Moneda'])

            ->add('payed', null, ['label'=> "El pago fue realizado con exito"])
            ->add('payedDate',  DateType::class, ['widget'=>'single_text','label'=> "Fecha en que se realiza el pago"])
           // ->add('drivermsg', TextareaType::class, ['label'=>'Mensaje al cliente','required'=>false]   )

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
