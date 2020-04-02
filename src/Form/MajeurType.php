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
                []
            )
            ->add('nom', TextType::class)
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
                    'widget'   => 'single_text',
                ]
            )
            ->add(
                'numeroSS',
                TextType::class,
                ['label' => 'Numéro de Sécurité Sociale']
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
                    'label' => 'Début de mesure',
                    'widget'   => 'single_text',
                ]
            )
            ->add(
                'finMesure',
                DateType::class,
                [
                    'label' => 'Fin de mesure',
                    'widget'   => 'single_text',
                ]
            )
            ->add('adresse', AdresseType::class)
            ->add(
                'tribunal',
                EntityType::class,
                [
                    'class' => TribunalEntity::class,
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
