<?php

namespace App\Form;

use App\Entity\JugementEntity;
use App\Entity\TribunalEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JugementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'numeroRG',
                TextType::class,
                [
                    'label' => 'N° Répertoire Général',
                ]
            )
            ->add(
                'dateJugement',
                DateType::class,
                [
                    'label' => 'Date du jugement',
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'debutMesure',
                DateType::class,
                [
                    'label' => 'Début',
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'finMesure',
                DateType::class,
                [
                    'label' => 'Fin',
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'tribunal',
                EntityType::class,
                [
                    'class' => TribunalEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JugementEntity::class,
        ]);
    }
}
