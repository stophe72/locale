<?php

namespace App\Form;

use App\Entity\MesureEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MesureType extends BaseCodeLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MesureEntity::class,
        ]);
    }
}
