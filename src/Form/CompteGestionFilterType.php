<?php

namespace App\Form;

use App\Entity\TypeOperationEntity;
use App\Models\CompteGestionFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteGestionFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $types = $options['typesOperation'];

        $builder
            ->add(
                'dateDebut',
                DateType::class,
                [
                    'label' => 'Date de début',
                    'widget' => 'single_text',
                    'required' => false,
                ]
            )
            ->add(
                'dateFin',
                DateType::class,
                [
                    'label' => 'Date de fin',
                    'widget' => 'single_text',
                    'required' => false,
                ]
            )
            ->add(
                'libelle',
                TextType::class,
                [
                    'label' => 'Libellé de l\'opération',
                    'required' => false,
                ]
            )
            ->add(
                'typeOperation',
                ChoiceType::class,
                [
                    'choices' => $types,
                    'label' => 'Type d\'opération',
                    'required' => false,
                    'placeholder' => 'Sélectionner un type d\'opération',
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'choice_label' => function (TypeOperationEntity $to) {
                        return $to->getLibelle();
                    },
                    'choice_value' => function (TypeOperationEntity $to = null) {
                        return $to ? $to->getId() : '';
                    },
                ]
            )
            ->add(
                'montant',
                NumberType::class,
                [
                    'required' => false,
                    'attr'     => [
                        'placeholder' => 'Montant',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => CompteGestionFilter::class,
        ]);
        $resolver->setRequired(
            [
                'typesOperation',
            ]
        );
    }
}
