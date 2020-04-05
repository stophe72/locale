<?php

namespace App\Form;

use App\Entity\AdresseEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'adresse1',
                TextType::class,
                [
                    'label' => 'Adresse',
                ]
            )
            ->add(
                'adresse2',
                TextType::class,
                [
                    'label' => 'Complément d\'adresse',
                    'required' => false,
                ]
            )
            ->add('codePostal', NumberType::class, [
                'label' => 'Code postal',
            ])
            ->add('ville', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdresseEntity::class,
        ]);
    }
}
