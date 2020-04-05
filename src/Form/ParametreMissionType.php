<?php

namespace App\Form;

use App\Entity\BaseUserEntity;
use App\Entity\ParametreMissionEntity;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametreMissionType extends BaseUserEntity
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ressources', MoneyType::class)
            ->add('nature')
            ->add('protection')
            ->add('lieuVie')
            ->add('periode')
            ->add('prestationSociale');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ParametreMissionEntity::class,
        ]);
    }
}
