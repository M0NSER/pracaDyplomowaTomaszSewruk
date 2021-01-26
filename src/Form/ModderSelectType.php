<?php

namespace App\Form;

use App\Dto\ModderSelectDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModderSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('votesInOptionInTournament', ChoiceType::class, [
                'label'        => false,
                'multiple'     => true,
                'expanded'     => true,
                'choices'      => $options['votesInOptionInTournament'],
                'choice_label' => function ($item) {
                    return $item;
                },
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'                => ModderSelectDto::class,
            'csrf_token_id'             => 'form_intention',
            'votesInOptionInTournament' => 'votesInOptionInTournament',
        ]);
    }
}
