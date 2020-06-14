<?php

namespace App\Form;

use App\Entity\PriseEnChargeEntity;
use App\Entity\TypePriseEnChargeEntity;
use App\Repository\TypePriseEnChargeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriseEnChargeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dateFin',
                DateType::class,
                [
                    'label' => 'Date de fin',
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'traite',
                CheckboxType::class,
                [
                    'label_attr' => [
                        'class' => 'switch-custom',
                    ],
                    'label' => 'Traité',
                    'required' => false,
                ]
            )
            ->add(
                'typePriseEnCharge',
                EntityType::class,
                [
                    'class' => TypePriseEnChargeEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'query_builder' => function (TypePriseEnChargeRepository $typePriseEnChargeRepository) {
                        return $typePriseEnChargeRepository->createQueryBuilder('pf')
                            ->orderBy('pf.libelle', 'ASC');
                    },
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PriseEnChargeEntity::class,
        ]);
    }
}
