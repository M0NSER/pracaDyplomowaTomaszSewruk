<?php

namespace App\Form;

use App\Dto\OptionInTournamentDto;
use Symfony\Component\Form\AbstractType;
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
            ->add('title', TextType::class,[
                'label'=>'Title',
                'required'=>true
            ])
            ->add('description', TextareaType::class, [
                'label'=>'Description',
                'required'=>false,
            ])
            ->add('numberOfSlots', IntegerType::class, [
                'label'=>'Quantity of free slots',
                'required'=>false,
            ])
            ->add('photoUrl', UrlType::class, [
                'label'=>'Photo url',
                'required'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OptionInTournamentDto::class,
        ]);
    }
}
