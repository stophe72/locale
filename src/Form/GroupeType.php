<?php

namespace App\Form;

use App\Entity\GroupeEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupeEntity::class,
        ]);
    }
}
