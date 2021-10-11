<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', null,[
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Saisir un nom de famille']
            ])
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => [
                        'ROLE_USER' => 'ROLE_USER',
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                        'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                        
                    ],
                    'multiple' => true,
                    // Affichage des éléments sous forme de cases à cocher
                    'expanded' => true
                ]
            )
            ->add('firstname', null,[
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Saisir un prénom']
            ])
            ->add('pseudo', null,[
                'label' => 'Pseudo',
                'attr' => ['placeholder' => 'Saisir un pseudo']
            ])
            ->add('email', null,[
                'label' => 'Email',
                'attr' => ['placeholder' => 'Saisir un email']
            ])
            ->add('city', null,[
                'label' => 'Ville',
                'attr' => ['placeholder' => 'Saisir une ville']
            ])
            ->add('age', null,[
                'label' => 'Age',
                'attr' => ['placeholder' => 'Saisir un âge']
            ])
            ->add('password', null,[
                'label' => 'Mot de passe',
                'attr' => ['placeholder' => 'Saisir un mot de passe']
            ])
            ->add('sport1', null,[
                'label' => 'Sport 1',
                'attr' => ['placeholder' => 'Saisir un premier sport']
            ])
            ->add('sport2', null,[
                'label' => 'Sport 2',
                'attr' => ['placeholder' => 'Saisir un second sport']
            ])
            ->add('sport3', null,[
                'label' => 'Sport 3',
                'attr' => ['placeholder' => 'Saisir un troisième sport']
            ])
            ->add('picture', FileType::class, [
                'label' => 'Choisir une image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Merci de ne choisir que des fichiers .png et .jpeg',
                    ])
                ],
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
