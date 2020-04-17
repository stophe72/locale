<?php

namespace App\Form;

use App\Entity\MajeurEntity;
use App\Entity\TribunalEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MajeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'civilite',
                ChoiceType::class,
                [
                    'label' => 'Civilité',
                    'choices' => [
                        'Madame' => 'Madame',
                        'Mademoiselle' => 'Mademoiselle',
                        'Monsieur' => 'Monsieur',
                    ],
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                ]
            )
            ->add('nom', TextType::class)
            ->add(
                'nomEtatCivil',
                TextType::class,
                [
                    'label' => 'Nom état civil',
                    'required' => false,
                ]
            )
            ->add(
                'prenom',
                TextType::class,
                [
                    'label' => 'Prénom',
                ]
            )
            ->add(
                'dateNaissance',
                DateType::class,
                [
                    'label' => 'Date de naissance',
                    'widget'   => 'single_text',
                ]
            )
            ->add('lieuNaissance', TextType::class)
            ->add(
                'numeroSS',
                TextType::class,
                [
                    'label' => 'N° Sécurité Sociale',
                ]
            )
            ->add(
                'numeroRG',
                TextType::class,
                [
                    'label' => 'N° Répertoire Général',
                ]
            )
            ->add(
                'nationalite',
                TextType::class,
                [
                    'label' => 'Nationalité',
                ]
            )
            ->add(
                'dateJugement',
                DateType::class,
                [
                    'label' => 'Date du jugement',
                    'widget'   => 'single_text',
                ]
            )
            ->add(
                'debutMesure',
                DateType::class,
                [
                    'label' => 'Début',
                    'widget'   => 'single_text',
                ]
            )
            ->add(
                'finMesure',
                DateType::class,
                [
                    'label' => 'Fin',
                    'widget'   => 'single_text',
                ]
            )
            ->add('adresse', AdresseType::class)
            ->add('contact', ContactType::class)
            ->add(
                'tribunal',
                EntityType::class,
                [
                    'class' => TribunalEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                ]
            )
            ->add(
                'parametreMission',
                ParametreMissionType::class
            )
            ->add(
                'dateFinCMU',
                DateType::class,
                [
                    'label' => 'Date de fin C.M.U.',
                    'widget'   => 'single_text',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MajeurEntity::class,
        ]);
    }
}
