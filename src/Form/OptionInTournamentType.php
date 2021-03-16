<?php

namespace App\Form;

use App\Dto\OptionInTournamentDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionInTournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'    => false,
                'required' => true,
                'attr'     => [
                    'placeholder' => 'Title',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label'    => false,
                'required' => false,
                'attr'     => [
                    'placeholder' => 'Description',
                ],
            ])
            ->add('numberOfSlots', IntegerType::class, [
                'label'    => false,
                'required' => false,
                'attr'     => [
                    'placeholder' => 'Quantity of free slots',
                ],
            ])
            ->add('photoUrl', HiddenType    ::class, [
                'label'    => false,
                'required' => false,
                'attr'     => [
                    'placeholder' => 'Photo url',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'    => OptionInTournamentDto::class,
            'csrf_token_id' => 'form_intention',
        ]);
    }
}
