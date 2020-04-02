<?php

namespace App\Form;

use App\Entity\TribunalEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TribunalType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TribunalEntity::class,
        ]);
    }
}
