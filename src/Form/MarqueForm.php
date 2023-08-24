<?php

namespace App\Form;

use App\Entity\Marque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class MarqueForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Votre nom de marque :',
                'required' => true,
                'sanitize_html' => true,
                'attr' => [
                    'placeholder' => 'Apple',
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Marque::class,
            'translation_domain' => 'form'
        ]);
    }
}
