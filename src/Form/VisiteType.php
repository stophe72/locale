<?php

namespace App\Form;

use App\Entity\MajeurEntity;
use App\Entity\VisiteEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $majeurs = $options['majeurs'];

        $builder
            ->add(
                'majeur',
                ChoiceType::class,
                [
                    'label' => 'Majeurs',
                    'choices' => $majeurs,
                    'choice_label' => function (MajeurEntity $majeur) {
                        return $majeur->getNom()  . ' ' . $majeur->getPrenom();
                    },
                    'choice_value' => function (MajeurEntity $majeur = null) {
                        return $majeur ? $majeur->getId() : '';
                    },
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                ]
            )
            ->add(
                'date',
                DateType::class,
                [
                    'widget' => 'single_text',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VisiteEntity::class,
        ]);
        $resolver->setRequired([
            'majeurs',
        ]);
    }
}
