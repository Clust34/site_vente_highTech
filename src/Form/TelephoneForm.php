<?php

namespace App\Form;

use App\Entity\Telephones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TelephoneForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du modèle :',
                'required' => true,
                'sanitize_html' => true,
                'attr' => [
                    'placeholder' => 'Iphone 75',
                ]
            ])
            ->add('metaTitle', TextType::class, [
                'label' => 'Méta-title de l\'article :',
                'required' => true,
                'sanitize_html' => true,
                'attr' => [
                    'placeholder' => 'Iphone sur mon site...',
                ]
            ])
            ->add('metaDescription', TextType::class, [
                'label' => 'Méta-description de l\'article :',
                'required' => true,
                'sanitize_html' => true,
                'attr' => [
                    'placeholder' => 'Description courte mais accrocheuse de l\'article',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description longue de l\'article :',
                'required' => true,
                'sanitize_html' => true,
                'attr' => [
                    'placeholder' => 'Description complète de l\'article',
                    'rows' => 5,
                ]
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix de l\'article :',
                'required' => true,
                'attr' => [
                    'placeholder' => 250,
                ]
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Quantité d\'article disponible :',
                'required' => true,
                'attr' => [
                    'placeholder' => 50
                ]
            ])
            ->add('marque', TextType::class, [
                'label' => 'Marque du téléphone :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Marque top'
                ]
            ])
            ->add('enable', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => TelephoneImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Telephones::class,
            'translation_domain' => 'form'
        ]);
    }
}
