<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class MessageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Votre nom :',
                'required' => true,
                'sanitize_html' => true,
                'attr' => [
                    'placeholder' => 'John',
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom :',
                'required' => true,
                'sanitize_html' => true,
                'attr' => [
                    'placeholder' => 'Doe',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'johndoe@exemple.com',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message :',
                'required' => true,
                'sanitize_html' => true,
                'attr' => [
                    'placeholder' => 'J\'aimerais des informations',
                    'rows' => 5,
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numéro de téléphone :',
                'required' => true,
                'attr' => [
                    'placeholder' => 0606060606,
                ]
            ])
            ->add('rgpd', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J\'accepte que mes données soient enregistrées',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'translation_domain' => 'form'
        ]);
    }
}
