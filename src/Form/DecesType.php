<?php

namespace App\Form;

use App\Entity\DecesEntity;
use App\Entity\PompeFunebreEntity;
use App\Repository\PompeFunebreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('concession')
            ->add(
                'cimetiere',
                TextType::class,
                [
                    'label' => 'Cimetière',
                    'required' => false,
                ]
            )
            ->add(
                'referenceConcession',
                TextType::class,
                [
                    'label' => 'Référence concession',
                    'required' => false,
                ]
            )
            ->add(
                'pompeFunebre',
                EntityType::class,
                [
                    'label' => 'Pompes funèbres',
                    'required' => false,
                    'class' => PompeFunebreEntity::class,
                    'query_builder' => function (PompeFunebreRepository $pompeFunebre) {
                        return $pompeFunebre->createQueryBuilder('pf')
                            ->orderBy('pf.libelle', 'ASC');
                    },
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DecesEntity::class,
        ]);
    }
}
