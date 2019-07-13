<?php

namespace AppBundle\Form;

use AppBundle\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Common features needed in controllers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 *
 * @property ContainerInterface $container
 */
class BookingType extends AbstractType
{

    /**
     * {@inheritdoc}
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options )
    {
        $booking = $options['data'];
        $builder
            ->add('place')
            ->add('ownroute')
            ->add('airport')
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
            ->add('airportname')
            ->add('telephone')
            ->add('serviceType',HiddenType::class)
            ->add('airportTransfer')
            ->add('transfer')
            ->add('targetPlace')
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
                    'attr' => ['class'=>'currency_select']
                ])
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
