<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


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
                'invalid_message' => 'Les mots de passe doivent correspondre',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe:',
                    'required' => true,
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'S3CR3T',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renter un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit être supérieur à {{ limit }} caractères.',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        new Regex(
                            pattern: '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/',
                            message: 'Votre mot de passe doit contenir au moins 1 nombre, 1 lettre en minuscule, 1 lettre en majuscule et un caractère spécial',
                        ),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe:',
                    'attr' => [
                        'placeholder' => 'S3CR3T',
                    ],
                    'required' => true,
                ],
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
