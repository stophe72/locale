<?php

namespace App\Form;

use App\Entity\TypePriseEnChargeEntity;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypePriseEnChargeType extends BaseCodeLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add(
                'alertable',
                CheckboxType::class,
                [
                    'label' => 'Alerte',
                    'required' => false,
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
