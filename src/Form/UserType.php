<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UserType extends AbstractType
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // On ajoute un eventListener
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $userToMdified = $event->getData();
            $userConnected = $this->security->getUser();

            // User connecter veut se modifier
            if ($userToMdified == $userConnected) {
                $form
                    ->add('prenom', TextType::class, [
                        'label' => 'Votre prénom : ',
                        'attr' => [
                            'placeholder' => 'John',
                        ],
                        'required' => true,
                    ])
                    ->add('nom', TextType::class, [
                        'label' => 'Votre nom : ',
                        'required' => true,
                        'attr' => [
                            'placeholder' => 'Doe',
                        ],
                    ])
                    ->add('adresse', TextType::class, [
                        'label' => 'Votre adresse : ',
                        'required' => true,
                        'attr' => [
                            'placeholder' => '1 rue de la gare',
                        ],
                    ])
                    ->add('zipCode', IntegerType::class, [
                        'label' => 'Votre code postal : ',
                        'required' => true,
                        'attr' => [
                            'placeholder' => '01000',
                        ],
                    ])
                    ->add('ville', TextType::class, [
                        'label' => 'Votre ville : ',
                        'required' => true,
                        'attr' => [
                            'placeholder' => 'Bourg en Bresse',
                        ],
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'Votre email : ',
                        'required' => true,
                        'attr' => [
                            'placeholder' => 'johndoe@exemple.com',
                        ],
                    ]);
            }

            // Modifier les roles
            if ($this->security->isGranted('ROLE_ADMIN')) {
                $form
                    ->add('roles', ChoiceType::class, [
                        'label' => 'Roles : ',
                        'choices' => [
                            'Utilisateur' => 'ROLE_USER',
                            'Éditeur' => 'ROLE_EDITEUR',
                            'Administrateur' => 'ROLE_ADMIN',
                        ],
                        'expanded' => false,
                        'multiple' => true,
                        'autocomplete' => true,
                    ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
