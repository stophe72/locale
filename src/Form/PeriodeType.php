<?php

namespace App\Form;

use App\Entity\PeriodeEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeriodeType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PeriodeEntity::class,
        ]);
    }
}
