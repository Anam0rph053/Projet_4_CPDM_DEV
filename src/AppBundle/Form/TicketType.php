<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
        public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class)
            ->add('firstName',TextType::class)
            ->add('birthDate', DateType::class, array(
                'widget'   => 'single_text'
            ) )
            ->add('country', CountryType::class)
            ->add('reducePrice', CheckboxType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
        public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ticket'
        ));
    }

        /**
         * {@inheritdoc}
         */
        public function getBlockPrefix()
    {
        return 'appbundle_ticket';
    }


}
