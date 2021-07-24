<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\File;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
            ->add('photo', FileType::class, [
                'label' => 'Ajouter une photo',
                'mapped' => false,
                'required' => false,
                'multiple' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048K',
                            'mimeTypes' => [
                                'image/png',
                                'image/jpg',
                                'image/jpeg',
                                'image/gif'
                            ]
                    ])
                ]
                ])
                // ->add('path', FileType::class, [
                //     'mapped' => false,
                //     'required' => true,
                //     'multiple' => false,
                //     'label' => "uploader votre image",
                //     'attr' => [
                //         'placeholder' => "parcourir pour trouver l'image"
                //     ],
                //     'constraints' => [
                //         new File([
                //             'maxSize' => '2048K',
                //             'mimeTypes' => [
                //                 'image/png',
                //                 'image/jpg',
                //                 'image/jpeg',
                //                 'image/gif'
                //             ]
                //         ])
                //     ]
                // ])
    
            // pour faire un select de la catégorie
            ->add('categorie_id', EntityType::class, [
                'label' => 'Choisir une catégorie',
                'placeholder' => '-- choisir  --',
                'choice_label' => 'cat',
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
