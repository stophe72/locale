<?php

namespace App\Form;

use App\Entity\FamilleCompteEntity;
use App\Entity\TypeCompteEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeCompteType extends BaseLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'familleCompte',
            EntityType::class,
            [
                'class' => FamilleCompteEntity::class,
                'attr' =>
                [
                    'class' => 'custom-select',
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeCompteEntity::class,
        ]);
    }
}
