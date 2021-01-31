<?php

namespace App\Form;

use App\Entity\Locale as EntityLocale;
use App\Entity\ProduitTranslation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitTranslationType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locales = $this->entityManager->getRepository(EntityLocale::class)->findAll();

        $builder
            ->add('locale', ChoiceType::class, [
                'choice_label' => 'code',
                'choices' => $locales,
            ])
            ->add('texte');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProduitTranslation::class,
        ]);
    }
}
