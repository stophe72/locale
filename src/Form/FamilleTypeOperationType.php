<?php

namespace App\Form;

use App\Entity\FamilleTypeOperationEntity;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FamilleTypeOperationType extends BaseLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add(
                'libelleRapport',
                TextType::class,
                [
                    'label' => 'Libellé rapport',
                    'required' => false,
                ]
            )->add(
                'ordreAffichage',
                IntegerType::class,
                [
                    'label' => 'Ordre d\'affichage',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FamilleTypeOperationEntity::class,
        ]);
    }
}
