<?php

namespace App\Form;

use App\Models\ImportCompteGestion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImportCompteGestionType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nomFichier',
                FileType::class,
                [
                    'label' => 'Fichier',
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
    }
}
