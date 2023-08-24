<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Telephones;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchMarqueForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('query', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('marques', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Telephones::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->andWhere('t.enable = true')
                        ->orderBy('t.marque', 'ASC');
                },
                'choice_label' => 'marque',
                'multiple' => true,
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
