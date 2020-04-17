<?php

namespace App\Form;

use App\Entity\FamilleCompteEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FamilleCompteType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FamilleCompteEntity::class,
        ]);
    }
}
