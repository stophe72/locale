<?php

namespace App\Form;

use App\Entity\AgenceBancaireEntity;
use App\Entity\DonneeBancaireEntity;
use App\Entity\MajeurEntity;
use App\Entity\TypeCompteEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonneeBancaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
                'numeroCompte',
                TextType::class,
                [
                    'label' => 'Numéro de compte',
                ]
            )
            ->add(
                'soldeCourant',
                MoneyType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'soldePrecedent',
                MoneyType::class,
                [
                    'label' => 'Solde précédent',
                    'required' => false,
                ]
            )
            ->add(
                'agenceBancaire',
                EntityType::class,
                [
                    'label' => 'Agence bancaire',
                    'class' => AgenceBancaireEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add(
                'typeCompte',
                EntityType::class,
                [
                    'label' => 'Type de compte',
                    'class' => TypeCompteEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DonneeBancaireEntity::class,
        ]);
    }
}
