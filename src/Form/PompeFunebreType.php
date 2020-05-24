<?php

namespace App\Form;

use App\Entity\PompeFunebreEntity;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PompeFunebreType extends BaseLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('adresse', AdresseType::class)
            ->add('contact', ContactType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PompeFunebreEntity::class,
        ]);
    }
}
