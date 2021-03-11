<?php

namespace App\Form;

use App\Entity\Vote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        dd($options['data']->getIdOptionInTournament()->getIdTournament()->getVotesQuantity());
        $builder
            ->add('priority', ChoiceType::class, [
                'choices'      => $options['priorityList'],
                'choice_label' => function ($item) {
                    return $item;
                },
            ])
            ->add('isSelectedByPromoter')
            ->add('deletedAt', DateTimeType::class, [
                'required'     => true,
                'input_format' => 'yyyy-MM-dd HH:mm:ss',
                'widget'       => 'single_text',
                'attr'         => [
                    'class' => 'field_custom datetimepicker',
                ],
            ])
            ->add('idOptionInTournament')
            ->add('idUser')
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Vote::class,
            'attr'            => [
                'class' => 'form_contant',
            ],
            'csrf_protection' => true,
            'csrf_token_id'   => 'form_intention',
            'priorityList'    => 'priorityList',
        ]);
    }
}
