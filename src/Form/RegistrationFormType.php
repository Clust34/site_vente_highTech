<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email ici : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'johndoe@exemple.com',
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'S3CR3T'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe dois faire plus de {{ limit }} caractères.',
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'Mot de passe : ',
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'S3CR3T',
                    ],
                    'label' => 'Répéter le mot de passe : ',
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'mapped' => false,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'John',
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Votre nom : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Doe',
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Votre adresse : ',
                'required' => true,
                'attr' => [
                    'placeholder' => '1 rue de la gare',
                ]
            ])
            ->add('zipCode', IntegerType::class, [
                'label' => 'Votre code postal : ',
                'required' => true,
                'attr' => [
                    'placeholder' => '01000',
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Votre ville ici : ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Bourg en Bresse',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
