<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('plainPassword', PasswordType::class, [
            //     // instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'mapped' => false,
            //     'attr' => ['autocomplete' => 'new-password'],
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Please enter a password',
            //         ]),
            //         new Length([
            //             'min' => 6,
            //             'minMessage' => 'Your password should be at least {{ limit }} characters',
            //             // max length allowed by Symfony for security reasons
            //             'max' => 4096,
            //         ]),
            //     ],
            // ])

            ->add('firstname', TextType::class, [
                'attr' => [
                    'maxlength' => 100
                ]
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'maxlength' => 100
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'maxlength' => 180
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'maxLenght' => 50
                ]
            ])
            ->add('region', TextType::class, [
                'attr' => [
                    'maxLenght' => 50
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe ne correspondent pas',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de renseigner un mot de passe'
                        ]),
                    ]
                ],
                'second_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de confirmer le mot de passe'
                        ])
                    ]
                ]
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos CGU',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'maxlength' => 2000
                ]
            ])
            ->add('kind', ChoiceType::class, [
                'choices' => [
                    'homme' => 'homme',
                    'femme' => 'femme',
                ]
            ])
            ->get('kind')
            ->addModelTransformer(new CallbackTransformer(
                fn ($kindAsArray) => count($kindAsArray) ? $kindAsArray[1] : null,
                fn ($kindAsString) => [$kindAsString]
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
