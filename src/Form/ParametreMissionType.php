<?php

namespace App\Form;

use App\Entity\LieuVieEntity;
use App\Entity\MesureEntity;
use App\Entity\ParametreMissionEntity;
use App\Entity\ProtectionEntity;
use App\Repository\LieuVieRepository;
use App\Repository\MesureRepository;
use App\Repository\ProtectionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametreMissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'mesure',
                EntityType::class,
                [
                    'class' => MesureEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'query_builder' => function (MesureRepository $MesureRepository) {
                        return $MesureRepository->createQueryBuilder('db')
                            ->orderBy('db.libelle', 'ASC');
                    },
                ]
            )
            ->add(
                'protection',
                EntityType::class,
                [
                    'class' => ProtectionEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'query_builder' => function (ProtectionRepository $protectionRepository) {
                        return $protectionRepository->createQueryBuilder('db')
                            ->orderBy('db.libelle', 'ASC');
                    },
                ]
            )
            ->add(
                'lieuVie',
                EntityType::class,
                [
                    'label' => 'Lieu de vie',
                    'class' => LieuVieEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'query_builder' => function (LieuVieRepository $lieuVieRepository) {
                        return $lieuVieRepository->createQueryBuilder('db')
                            ->orderBy('db.libelle', 'ASC');
                    },
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
