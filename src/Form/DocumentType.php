<?php

namespace App\Form;

use App\Entity\DocumentEntity;
use App\Entity\MajeurEntity;
use App\Repository\MajeurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'majeur',
                EntityType::class,
                [
                    'class' => MajeurEntity::class,
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'query_builder' => function (MajeurRepository $majeurRepository) {
                        return $majeurRepository->createQueryBuilder('d')
                            ->orderBy('d.nom', 'ASC')
                            ->addOrderBy('d.prenom', 'ASC');
                    },

                ]
            )
            ->add(
                'libelle',
                TextType::class,
                [
                    'label' => 'Libellé',
                ]
            )
            ->add(
                'observations',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'fichier',
                FileType::class,
                [
                    'label' => 'Fichier',
                    // 'mapped'      => false,
                    'data_class' => null,
                    'attr'        => [
                        'placeholder' => 'Choisir un fichier',
                    ],
                    'constraints' => [
                        new File(
                            [
                                'maxSize' => '4096k',
                                'mimeTypes' => [
                                    'application/pdf',
                                    'application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                                ],
                                'mimeTypesMessage' => 'Merci de choisir un fichier valide (*.doc, *.docx, *.pdf. 4 Mo maximum)',
                            ]
                        )
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DocumentEntity::class,
        ]);
    }
}
