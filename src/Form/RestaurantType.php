<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('description')
            ->add('nationalite')
            ->add('specificite')
            ->add('prix_moyen')
            ->add('photo')
            // pour faire un select de la catégorie
            ->add('categorie_id', EntityType::class, [
                'label' => 'choisir une catégorie',
                'placeholder' => '-- choisir  --',
                'choice_label' => 'nom',
                'class' => Categorie::class
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
