<?php

namespace App\Form;

use App\Entity\BanqueEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BanqueType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BanqueEntity::class,
        ]);
    }
}
