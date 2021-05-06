<?php

namespace App\Form;

use App\Entity\ImportOperationEntity;
use App\Entity\MajeurEntity;
use App\Entity\TypeOperationEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImportOperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typesOperation = $options['typesOperation'];
        $builder
            ->add(
                'libelle',
                TextType::class,
                [
                    'label' => 'Libellé',
                ]
            )
            ->add(
                'majeur',
                EntityType::class,
                [
                    'class' => MajeurEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                ]
            )
            ->add(
                'typeOperation',
                ChoiceType::class,
                [
                    'choices' => $typesOperation,
                    'label' => 'Type d\'opération',
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'choice_label' => function (TypeOperationEntity $no) {
                        return $no->getLibelle();
                    },
                    'choice_value' => function (TypeOperationEntity $no = null) {
                        return $no ? $no->getId() : '';
                    },
                ]
            )
            ->add(
                'nature',
                ChoiceType::class,
                [
                    'choices' => [
                        'Crédit' => 1,
                        'Débit' => -1,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add(
                'caseSensible',
                CheckboxType::class,
                [
                    'required' => false,
                    'label'    => 'Sensible à la casse',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImportOperationEntity::class,
        ]);
        $resolver->setRequired(
            [
                'typesOperation',
            ]
        );
    }
}
