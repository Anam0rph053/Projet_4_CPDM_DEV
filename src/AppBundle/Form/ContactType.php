<?php

namespace AppBundle\Form;


use AppBundle\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, array('attr' => array('placeholder' => 'Votre Nom')))
            ->add('firstName', TextType::class, array('attr' => array('placeholder' => 'Votre Prénom')))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Votre Adresse Email')))
            ->add('object', TextType::class, array('attr' => array('placeholder' => 'l\'Objet de votre message')))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Rédigez votre message')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => contact::class
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }

}
