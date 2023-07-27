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

    const tailleUnique = 'taille unique';
    const sizeA = '36';
    const sizeB =  '37';
    const sizeC =  '38';
    const sizeD =  '39';
    const sizeE =  '40';
    const sizeF =  '41';
    const sizeG =  '42';
    const sizeH =  '43';
    const sizeI =  '44';
    const sizeJ =  '45';
    const sizeK =  '46';
    const sizeL =  '47';
    const sizeM =  '48';
    const sizeN =  '49';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('size', ChoiceType::class, [
                'choices' => [
                    'taille unique' => self::tailleUnique,
                    '36'=> self::sizeA,
                    '37' => self::sizeB,
                    '38' => self::sizeC,
                    '39' => self::sizeD,
                    '40' => self::sizeE,
                    '41' => self::sizeF,
                    '42' => self::sizeG,
                    '43' => self::sizeH,
                    '44' => self::sizeI,
                    '45' => self::sizeJ,
                    '46' => self::sizeK,
                    '47' => self::sizeL,
                    '48' => self::sizeM,
                    '49' => self::sizeN,
                ],
                'expanded'  => true,
                'multiple'  => true,
                ])
                ->add('price')
            ->add('year')
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
        ]);
    }
}
