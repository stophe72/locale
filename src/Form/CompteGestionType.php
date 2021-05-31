<?php

namespace App\Form;

use App\Entity\CompteGestionEntity;
use App\Entity\DonneeBancaireEntity;
use App\Entity\TypeOperationEntity;
use App\Repository\DonneeBancaireRepository;
use App\Repository\TypeOperationRepository;
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
            ->add('donneeBancaire', EntityType::class, [
                'class' => DonneeBancaireEntity::class,
                'label' => 'Compte bancaire',
                'attr' => [
                    'class' => 'custom-select',
                ],
                'query_builder' => function (
                    DonneeBancaireRepository $donneeBancaireRepository
                ) {
                    return $donneeBancaireRepository
                        ->createQueryBuilder('db')
                        ->orderBy('db.numeroCompte', 'ASC');
                },
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('typeOperation', EntityType::class, [
                'label' => 'Type d\'opération',
                'class' => TypeOperationEntity::class,
                'attr' => [
                    'class' => 'custom-select',
                ],
                'query_builder' => function (
                    TypeOperationRepository $typeOperationRepository
                ) {
                    return $typeOperationRepository
                        ->createQueryBuilder('to')
                        ->orderBy('to.libelle', 'ASC');
                },
            ])
            ->add('montant', MoneyType::class)
            ->add('nature', ChoiceType::class, [
                'choices' => [
                    'Crédit' => 1,
                    'Débit' => -1,
                ],
                'expanded' => true,
                'multiple' => false,
                'label_attr' => ['class' => 'radio-inline'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompteGestionEntity::class,
        ]);
    }
}
