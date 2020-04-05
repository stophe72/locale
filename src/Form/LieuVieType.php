<?php

namespace App\Form;

use App\Entity\LieuVieEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuVieType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LieuVieEntity::class,
        ]);
    }
}
