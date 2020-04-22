<?php

namespace App\Form;

use App\Entity\UserEntity;
use App\Entity\UserGroupeEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add(
                'prenom',
                TextType::class,
                [
                    'label' => 'Prénom',
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Adresse email',
                ]
            )
            ->add(
                'administrateur',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'mapped' => false,
                    'label'  => 'Mot de passe',
                ]
            )
            ->add(
                'groupe',
                EntityType::class,
                [
                    'class' => UserGroupeEntity::class,
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
            'data_class' => UserEntity::class,
        ]);
    }
}
