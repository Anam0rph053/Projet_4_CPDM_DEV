<?php

namespace AppBundle\Form;

use AppBundle\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDate', DateType::class, array(
                'widget'   =>'single_text',
            ))
            ->add('ticketNumber', ChoiceType::class, array(
                'choices' => array_combine(range(Booking::MIN_TICKETS_PER_BOOKING,Booking::MAX_TICKETS_PER_BOOKING),range(Booking::MIN_TICKETS_PER_BOOKING,Booking::MAX_TICKETS_PER_BOOKING))
            ))
            ->add('email', EmailType::class)
            ->add('ticketType', ChoiceType::class,
                array(
                    'choices' => array(
                        'Billet Journée' => Booking::TYPE_FULL_DAY ,
                        'Billet Demi Journée' => Booking::TYPE_HALF_DAY
                    )
                ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Booking::class,
            'validation_groups' => ['booking_init']
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
