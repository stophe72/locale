<?php

namespace App\Form;

use App\Entity\TypeFraisEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeFraisType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeFraisEntity::class,
        ]);
    }
}
