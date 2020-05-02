<?php

namespace App\Form;

use App\Entity\FamilleTypeOperationEntity;
use App\Entity\TypeOperationEntity;
use App\Repository\FamilleTypeOperationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeOperationType extends BaseLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add(
                'libelleRapport',
                TextType::class,
                [
                    'label' => 'Libellé rapport',
                    'required' => false,
                ]
            )
            ->add(
                'familleTypeOperation',
                EntityType::class,
                [
                    'class' => FamilleTypeOperationEntity::class,
                    'label' => 'Famille de types d\'opération',
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'query_builder' => function (FamilleTypeOperationRepository $familleTypeOperationRepository) {
                        return $familleTypeOperationRepository->createQueryBuilder('fto')
                            ->orderBy('fto.libelle', 'ASC');
                    },
                ]
            )
            ->add(
                'checkable',
                CheckboxType::class,
                [
                    'label' => 'Rapport - Case à cocher',
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeOperationEntity::class,
        ]);
    }
}
