<?php

namespace App\Form;

use App\Entity\CompteGestionEntity;
use App\Entity\DonneeBancaireEntity;
use App\Entity\MajeurEntity;
use App\Entity\TypeOperationEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteGestionType extends BaseLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add(
                'donneeBancaire',
                EntityType::class,
                [
                    'class' => DonneeBancaireEntity::class,
                    'label' => 'Compte bancaire',
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add(
                'majeur',
                EntityType::class,
                [
                    'class' => MajeurEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
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
                    ]
                ]
            )
            ->add('montant', MoneyType::class)
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
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompteGestionEntity::class,
        ]);
    }
}
