<?php

namespace App\Form;

use App\Entity\MajeurEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'lieuNaissance',
                TextType::class,
                [
                    'attr' => [
                        'style' => 'text-transform:uppercase',
                    ],
                ]
            )
            ->add(
                'numeroSS',
                TextType::class,
                [
                    'label' => 'N° Sécurité Sociale',
                ]
            )
            ->add(
                'nationalite',
                TextType::class,
                [
                    'label' => 'Nationalité',
                ]
            )
            ->add('adresse', AdresseType::class)
            ->add('contact', ContactType::class)
            ->add(
                'image',
                FileType::class,
                [
                    'label' => 'Photo',
                    'mapped'      => false,
                    'required'    => false,
                    'attr'        => [
                        'placeholder' => 'Choisir une photo',
                    ],
                    'constraints' => [
                        new File(
                            [
                                'maxSize' => '2048k',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png'
                                ],
                                'mimeTypesMessage' => 'Merci de choisir une photo valide (*.png, *.jpg. 2 Mo maximum)',
                            ]
                        )
                    ],
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
