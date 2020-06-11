<?php

namespace App\Form;

use App\Entity\MajeurEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $majeurs = $options['majeurs'];

        $builder
            ->add(
                'majeur',
                ChoiceType::class,
                [
                    'choices' => $majeurs,
                    'label' => 'Majeur',
                    'required' => false,
                    'placeholder' => 'Sélectionner un majeur',
                    'attr' => [
                        'class' => 'custom-select',
                        'size' => 12,
                    ],
                    'choice_label' => function (MajeurEntity $majeur) {
                        return $majeur->__toString();
                    },
                    'choice_value' => function (MajeurEntity $majeur = null) {
                        return $majeur ? $majeur->getId() : '';
                    },
                ]
            )
            ->add(
                'libelle',
                TextType::class,
                [
                    'label' => 'Libellé',
                    'required' => false,
                ]
            )
            ->add(
                'observations',
                TextType::class,
                [
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => DocumentFilter::class,
        ]);
        $resolver->setRequired(
            [
                'majeurs',
            ]
        );
    }
}
