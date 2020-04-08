<?php

namespace App\Form;

use App\Entity\BanqueEntity;
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
            ->add('numeroCompte', TextType::class)
            ->add('solde', MoneyType::class)
            ->add(
                'banque',
                EntityType::class,
                [
                    'class' => BanqueEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add(
                'typeCompte',
                EntityType::class,
                [
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
