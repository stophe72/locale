<?php

namespace App\Form;

use App\Entity\MajeurEntity;
use App\Models\ImportCompteGestion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImportCompteGestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'majeur',
                EntityType::class,
                [
                    'class' => MajeurEntity::class,
                    'attr' =>
                    [
                        'class' => 'custom-select',
                    ],
                ]
            )
            ->add(
                'nomFichier',
                FileType::class,
                [
                    'label' => 'Fichier à importer',
                    'attr'        => [
                        'placeholder' => 'Choisir un fichier CSV',
                    ],
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            // 'mimeTypes' => [
                            //     'text/csv',
                            // ],
                            'mimeTypesMessage' => 'Merci de choisir un fichier CSV valide (*.csv, 1 Mo maximum)',
                        ])
                    ],
                ]

            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImportCompteGestion::class,
        ]);
        $resolver->setRequired(
            [
                'majeurs',
            ]
        );
    }
}
