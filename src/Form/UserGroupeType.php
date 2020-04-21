<?php

namespace App\Form;

use App\Entity\UserGroupeEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserGroupeType extends BaseLibelleType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserGroupeEntity::class,
        ]);
    }
}
