<?php

namespace App\Form;

use App\Entity\TypePriseEnChargeEntity;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypePriseEnChargeType extends BaseCodeLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add(
                'seuilAlerte',
                RangeType::class,
                [
                    'label' => 'Seuil d`alerte (en semaines)',
                    'attr'  => [
                        'min' => 0,
                        'max' => 52,
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypePriseEnChargeEntity::class,
        ]);
    }
}
