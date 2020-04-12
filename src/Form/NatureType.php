<?php

namespace App\Form;

use App\Entity\NatureEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NatureType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NatureEntity::class,
        ]);
    }
}