<?php

namespace App\Form;

use App\Entity\MandataireEntity;
use App\Entity\GroupeEntity;
use App\Entity\UserEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MandataireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'user',
                EntityType::class,
                [
                    'label' => 'Utilisateur',
                    'class' => UserEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add(
                'nom',
                TextType::class,
                [
                    'attr' => [
                        'style' => 'text-transform:uppercase',
                    ]
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
                'groupe',
                EntityType::class,
                [
                    'class' => GroupeEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add('adresse', AdresseType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MandataireEntity::class,
        ]);
    }
}
