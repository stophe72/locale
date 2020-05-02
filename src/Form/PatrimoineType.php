<?php

namespace App\Form;

use App\Entity\PatrimoineEntity;
use App\Entity\TypeOperationEntity;
use App\Repository\TypeOperationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatrimoineType extends BaseLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add(
                'date',
                DateType::class,
                [
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'typeOperation',
                EntityType::class,
                [
                    'label' => 'Type d\'opération',
                    'class' => TypeOperationEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'query_builder' => function (TypeOperationRepository $typeOperationRepository) {
                        return $typeOperationRepository->createQueryBuilder('to')
                            ->orderBy('to.libelle', 'ASC');
                    },
                ]
            )
            ->add(
                'nature',
                ChoiceType::class,
                [
                    'label' => 'Type d\'opération',
                    'choices' => [
                        'Achat' => 1,
                        'Vente' => -1,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add('montant', MoneyType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PatrimoineEntity::class,
        ]);
    }
}
