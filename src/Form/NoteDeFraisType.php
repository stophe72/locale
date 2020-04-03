<?php

namespace App\Form;

use App\Entity\NoteDeFraisEntity;
use App\Entity\TypeFraisEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteDeFraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'date',
                DateType::class,
                [
                    'widget' => 'single_text',
                ]
            )
            ->add('montant', MoneyType::class)
            ->add(
                'typeFrais',
                EntityType::class,
                [
                    'label' => 'Type de frais',
                    'class' => TypeFraisEntity::class,
                    'attr' =>
                    [
                        'class' => 'custom-select',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NoteDeFraisEntity::class,
        ]);
    }
}
