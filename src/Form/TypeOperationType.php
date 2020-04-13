<?php

namespace App\Form;

use App\Entity\TypeOperationEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeOperationType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeOperationEntity::class,
        ]);
    }
}
