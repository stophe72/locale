<?php

namespace App\Form;

use App\Models\VisiteFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dateDebut',
                DateType::class,
                [
                    'label' => 'Date de début',
                    'widget' => 'single_text',
                    'required' => false,
                ]
            )
            ->add(
                'dateFin',
                DateType::class,
                [
                    'label' => 'Date de fin',
                    'widget' => 'single_text',
                    'required' => false,
                ]
            )
            ->add(
                'majeurNom',
                TextType::class,
                [
                    'label' => 'Nom',
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => VisiteFilter::class,
        ]);
    }
}
