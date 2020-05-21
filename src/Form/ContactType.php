<?php

namespace App\Form;

use App\Entity\ContactEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'telephone',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Téléphone',
                ]
            )
            ->add(
                'mobile',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactEntity::class,
        ]);
    }
}
