<?php

namespace App\Form;

use App\Entity\NatureOperationEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NatureOperationType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NatureOperationEntity::class,
        ]);
    }
}
