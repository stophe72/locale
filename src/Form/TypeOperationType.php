<?php

namespace App\Form;

use App\Entity\TypeOperationEntity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeOperationType extends BaseLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add(
                'type',
                ChoiceType::class,
                [
                    'label' => 'Type d\'opération',
                    'choices' => [
                        'Crédit' => 1,
                        'Débit' => -1,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeOperationEntity::class,
        ]);
    }
}
