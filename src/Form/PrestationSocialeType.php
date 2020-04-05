<?php

namespace App\Form;

use App\Entity\PrestationSocialeEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestationSocialeType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PrestationSocialeEntity::class,
        ]);
    }
}
