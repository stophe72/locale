<?php

namespace App\Form;

use App\Entity\ProduitTranslation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('locale', EntityType::class, [
            //     'attr'          => [
            //         'class' => 'custom-select',
            //     ],
            //     'label'         => 'Traduction',
            //     'class'         => Locale::class,
            //     'query_builder' => function (LocaleRepository $localeRepository) {
            //         return $localeRepository->createQueryBuilder('l')
            //             ->orderBy('l.libelle', 'ASC');
            //     },
            // ])
            ->add('locale', HiddenType::class)
            ->add('texte', TextType::class, [
                'label' => 'Libellé',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProduitTranslation::class,
        ]);
    }
}
