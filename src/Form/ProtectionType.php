<?php

namespace App\Form;

use App\Entity\ProtectionEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProtectionType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProtectionEntity::class,
        ]);
    }
}
