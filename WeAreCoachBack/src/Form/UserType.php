<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null,[
                'label' => 'Nom du sport',
                'attr' => ['placeholder' => 'Saisir un nom de sport']
            ])
            ->add('roles', null,[
                'label' => 'Nom du sport',
                'attr' => ['placeholder' => 'Saisir un nom de sport']
            ])
            ->add('password', null,[
                'label' => 'Nom du sport',
                'attr' => ['placeholder' => 'Saisir un nom de sport']
            ])
            ->add('pseudo', null,[
                'label' => 'Nom du sport',
                'attr' => ['placeholder' => 'Saisir un nom de sport']
            ])
            ->add('firstname', null,[
                'label' => 'Nom du sport',
                'attr' => ['placeholder' => 'Saisir un nom de sport']
            ])
            ->add('lastname', null,[
                'label' => 'Nom du sport',
                'attr' => ['placeholder' => 'Saisir un nom de sport']
            ])
            ->add('city', null,[
                'label' => 'Nom du sport',
                'attr' => ['placeholder' => 'Saisir un nom de sport']
            ])
            ->add('age', null,[
                'label' => 'Level',
                'attr' => ['placeholder' => 'Saisir le niveau']
            ])
            ->add('sport1', null,[
                'label' => 'Nom du sport',
                'attr' => ['placeholder' => 'Saisir un nom de sport']
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
