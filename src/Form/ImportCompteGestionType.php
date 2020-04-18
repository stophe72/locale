<?php

namespace App\Form;

use App\Entity\DonneeBancaireEntity;
use App\Entity\MajeurEntity;
use App\Models\ImportCompteGestion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                'majeur',
                EntityType::class,
                [
                    'class' => MajeurEntity::class,
                    'placeholder' => 'Sélectionner d`abord un majeur',
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
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                $this->addDonneeBancaire($event->getForm(), $data == null ? null : $data->getMajeur());
            }
        );
        $builder->get('majeur')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $majeur = $event->getForm()->getData();
                $this->addDonneeBancaire($event->getForm()->getParent(), $majeur);
            }
        );
    }

    private function addDonneeBancaire(FormInterface $form, MajeurEntity $majeur = null)
    {
        $repoDonneeBancaire = $this->entityManager->getRepository(DonneeBancaireEntity::class);
        if (null === $majeur) {
            $dbs = [];
        } else {
            $dbs = $repoDonneeBancaire->findBy(
                [
                    'majeur' => $majeur->getId(),
                ],
                [
                    // 'numeroCompte' => 'ASC',
                ]
            );
        }

        $form->add(
            'donneeBancaire',
            ChoiceType::class,
            [
                'label'        => 'Compte bancaire',
                'choice_label' => function (DonneeBancaireEntity $donneeBancaire) {
                    return $donneeBancaire->getNumeroCompte();
                },
                'choice_value' => function (DonneeBancaireEntity $donneeBancaire = null) {
                    return $donneeBancaire ? $donneeBancaire->getId() : '';
                },
                'choices' => $dbs,
                'placeholder' => 'Sélectionner un compte',
                'attr' =>
                [
                    'class' => 'custom-select',
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
