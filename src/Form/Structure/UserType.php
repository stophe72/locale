<?php

namespace App\Form\Structure;

use App\Model\Structure\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('email', TextType::class, [
                'required' => false,
            ])
            ->add('contact', CheckboxType::class, [
                'required' => false,
            ]);

/*
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $user = $event->getData();
                $this->update($event->getForm(), $user == null ? null : $user);
            }
        );
        $builder->get('contact')->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $user = $event->getForm()->getData();
                $u2 = $event->getForm()->getParent()->getData();
                $this->update($event->getForm()->getParent(), $u2);
            }
        );*/
    }

    protected function update(FormInterface $form, User $user = null)
    {
        $formOptions = [];
        if (null !== $user) {
            $formOptions['required'] = $user->isContact() ?? false;
        }

        $form->add(
            'email',
            TextType::class,
            $formOptions
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
