<?php

namespace App\Form;

use App\Entity\LieuVieEntity;
use App\Entity\NatureEntity;
use App\Entity\ParametreMissionEntity;
use App\Entity\PeriodeEntity;
use App\Entity\PrestationSocialeEntity;
use App\Entity\ProtectionEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametreMissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ressources', MoneyType::class)
            ->add(
                'nature',
                EntityType::class,
                [
                    'class' => NatureEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add(
                'protection',
                EntityType::class,
                [
                    'class' => ProtectionEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add(
                'lieuVie',
                EntityType::class,
                [
                    'class' => LieuVieEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add(
                'periode',
                EntityType::class,
                [
                    'class' => PeriodeEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add(
                'prestationSociale',
                EntityType::class,
                [
                    'class' => PrestationSocialeEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ParametreMissionEntity::class,
        ]);
    }
}
