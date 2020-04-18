<?php

namespace App\Form;

use App\Entity\AgenceBancaireEntity;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgenceBancaireType extends BaseLibelleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add(
                'telephone',
                TextType::class,
                [
                    'label' => 'Téléphone',
                ]
            )
            ->add(
                'codeBanque',
                TextType::class,
                [
                    'label' => 'Code banque',
                ]
            )
            ->add(
                'email',
                TextType::class
            )
            ->add(
                'contact',
                TextType::class,
                [
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AgenceBancaireEntity::class,
        ]);
    }
}
