<?php

namespace App\Form;

use App\Entity\NoteDeFraisEntity;
use App\Entity\TypeFraisEntity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteDeFraisType extends BaseLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $typesFrais = $options['typesFrais'];

        $builder
            ->add(
                'date',
                DateType::class,
                [
                    'widget' => 'single_text',
                ]
            )
            ->add('lieu', TextType::class)
            ->add('montant', MoneyType::class)
            ->add(
                'typeFrais',
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                    'label' => 'Type de frais',
                    'choices' => $typesFrais,
                    'choice_label' => function (TypeFraisEntity $typeFrais) {
                        return $typeFrais->getLibelle();
                    },
                    'choice_value' => function (TypeFraisEntity $typeFrais = null) {
                        return $typeFrais ? $typeFrais->getId() : '';
                    },
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NoteDeFraisEntity::class,
        ]);
        $resolver->setRequired(
            [
                'typesFrais',
            ]
        );
    }
}
