<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'required'    => true,
                'label'       => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter Your first name',
                    ]),
                ],
                'attr'        => [
                    'placeholder' => 'First Name',
                ],
            ])
            ->add('lastName', TextType::class, [
                'required'    => true,
                'label'       => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter Your last name',
                    ]),
                ],
                'attr'        => [
                    'placeholder' => 'Last Name',
                ],
            ])
            ->add('email', EmailType::class, [
                'required'    => true,
                'label'       => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter Your email',
                    ]),
                    new Email(),
                ],
                'attr'        => [
                    'placeholder' => 'Email',
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label'       => 'I agree to the terms',
                'mapped'      => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type'           => PasswordType::class,
                'first_options'  => [
                    'label'       => 'Password',
                    'required'    => true,
                    'attr'        => [
                        'placeholder' => 'Password',
                    ],
                    'constraints' => [
                        new NotBlank(),
                        new Type([
                            'type' => 'string',
                        ]),
                        new Regex([
                            'pattern'     => "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/i",
                            'htmlPattern' => "^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$",
                            'message'     => "Value should have minimum 8 characters, at least one letter and one number",
                        ]),
                    ],
                ],
                'second_options' => [
                    'label'    => 'Repeat Password',
                    'required' => true,
                    'attr'     => [
                        'placeholder' => 'Repeat password',
                    ],
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => User::class,
            'csrf_protection' => true,
        ]);
    }
}
