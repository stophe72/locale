<?php

namespace App\Form;

use App\Entity\TypeCompteEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeCompteType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeCompteEntity::class,
        ]);
    }
}
