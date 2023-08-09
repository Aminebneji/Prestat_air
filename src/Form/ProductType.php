<?php

namespace App\Form;

use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType{ 

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('adminSelectedsize', ChoiceType::class, [
                'choices' => [
                    'taille unique' => 'taille unique',
                    '36'=> '36',
                    '37' => '37' ,
                    '38' => '38',
                    '39' => '39',
                    '40' => '40',
                    '41' => '41',
                    '42' => '42',
                    '43' => '43',
                    '44' => '44',
                    '45' => '45',
                    '46' => '46',
                    '47' => '47',
                    '48' => '48',
                    '49' => '49',
                ],
                'label' => 'Choisir la taille de la chaussure',
                'expanded'  => true,
                'multiple'  => true,
                ])
                ->add('price')
            ->add('description', TextareaType::class, [
                'attr' => [
                    'maxlength' => 2000
                ]
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'help' => 'png, jpg, jpeg, jp2 ou webp - 1 Mo max',
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}).',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'required {{ types }}.'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
            'availableSizes' => [],

        ]);
    }
}
