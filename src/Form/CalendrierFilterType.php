<?php

namespace App\Form;

use App\Models\CalendrierVisiteFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendrierFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'annee',
                ChoiceType::class,
                [
                    'label'   => 'Année',
                    'choices' => $this->buildYearsList(),
                    'attr' => [
                        'class' => 'custom-select',
                    ]
                ]
            )
            ->add(
                'majeurNom',
                TextType::class,
                [
                    'label' => 'Nom',
                    'required' => false,
                ]
            )
            ->add('majeurId', HiddenType::class);
    }


    private function buildYearsList()
    {
        $a = range(date('Y'), date('Y') - 10);

        return array_combine($a, $a);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => CalendrierVisiteFilter::class,
        ]);
    }
}
