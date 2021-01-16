<?php

namespace App\Form;

use App\Dto\TournamentDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label'    => false,
                'attr'     => [
                    'class'       => 'field_custom',
                    'placeholder' => 'Name',
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'class'       => 'field_custom',
                    'placeholder' => 'Description',
                ],
            ])
            ->add('voteToDatetime', DateTimeType::class, [
                'required'     => false,
                'input_format' => 'yyyy-MM-dd HH:mm:ss',
                'label'        => 'Students can vote to: ',
                'widget'       => 'single_text',
                'attr'         => [
                    'class' => 'field_custom datetimepicker',
                ],
            ])
            ->add('selectToDatetime', DateTimeType::class, [
                'required'     => false,
                'input_format' => 'yyyy-MM-dd HH:mm:ss',
                'label'        => 'Promoters can select to: ',
                'widget'       => 'single_text',
                'attr'         => [
                    'class' => 'field_custom datetimepicker',
                ],
            ])
            ->add('votesQuantity', NumberType::class, [
                'required' => true,
                'label'    => 'Quantity of votes',
            ])
            ->add('isPublic', CheckboxType::class, [
                'required' => false,
                'label'    => 'Make it public?',
                'attr'     => [
                    'class' => 'field_custom',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => TournamentDto::class,
            'attr'            => [
                'class' => 'form_contant',
            ],
            'csrf_protection' => true,
            'csrf_token_id'   => 'form_intention',
        ]);
    }
}
