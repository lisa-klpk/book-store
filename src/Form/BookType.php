<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookKind;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// DTO => Data Transfer Objet

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du livre :',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du livre :',
                'attr' => [
                    'class' => 'super-description'
                ]
            ])
            ->add('image', UrlType::class, [
                'label' => 'Image du livre :',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du livre :',
            ])
            ->add('kind', EntityType::class, [
                'class' => BookKind::class,
                'choice_label' => 'name',
                'label' => 'Genre :',
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => 'Auteur :',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter le livre',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
