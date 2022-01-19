<?php

namespace App\Form;

use App\DTO\BookSearchCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookSearchCriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('limit', NumberType::class, [
                'label' => 'Nombre de résultats :',
                'required' => true,
            ])
            ->add('page', NumberType::class, [
                'label' => 'Page :',
                'required' => true,
            ])
            ->add('startingPrice', MoneyType::class, [
                'label' => 'Prix minimum :',
                'required' => false,
            ])
            ->add('endingPrice', MoneyType::class, [
                'label' => 'Prix maximum :',
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom :',
                'required' => false,
            ])
            ->add('orderBy', ChoiceType::class, [
                'label' => 'Trier par :',
                'choices' => [
                    'Date de création' => 'createdAt',
                    'Nom' => 'name',
                    'Identifiant' => 'id',
                ],
                'required' => true,
            ])
            ->add('direction', ChoiceType::class, [
                'label' => 'Sens du trie :',
                'choices' => [
                    'Croissant' => 'ASC',
                    'Décroissant' => 'DESC',
                ],
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookSearchCriteria::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
