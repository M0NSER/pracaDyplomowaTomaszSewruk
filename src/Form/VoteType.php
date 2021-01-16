<?php

namespace App\Form;

use App\Dto\VoteDto;
use App\Repository\OptionInTournamentRepository;
use App\Repository\TournamentRepository;
use App\Repository\VoteRepository;
use App\Service\VoteService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteType extends AbstractType
{
    /**
     * @var TournamentRepository
     */
    private TournamentRepository $tournamentRepository;
    /**
     * @var VoteRepository
     */
    private VoteRepository $voteRepository;

    /**
     * @var OptionInTournamentRepository
     */
    private OptionInTournamentRepository $optionInTournamentRepository;
    /**
     * @var VoteService
     */
    private VoteService $voteService;

    /**
     * VoteType constructor.
     *
     * @param TournamentRepository         $tournamentRepository
     * @param VoteRepository               $voteRepository
     * @param OptionInTournamentRepository $optionInTournamentRepository
     * @param VoteService                  $voteService
     */
    public function __construct(TournamentRepository $tournamentRepository, VoteRepository $voteRepository, OptionInTournamentRepository $optionInTournamentRepository, VoteService $voteService)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->voteRepository = $voteRepository;
        $this->optionInTournamentRepository = $optionInTournamentRepository;
        $this->voteService = $voteService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priority', ChoiceType::class, [
                'label'   => 'Choose priority',
                'choices' =>
                    [
                        'Priority' => $options['prioritiesList'],
                    ],

                'expanded'             => false,
                'multiple'             => false,
                'choice_label'         => function ($value) {
                    return $value != null ? $value : 'Choose one';
                },
                'allow_extra_fields'   => true,
                'extra_fields_message' => 'Not this way ;)',
                'required'             => true,
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'    => VoteDto::class,
            'csrf_token_id' => 'form_intention',
            'prioritiesList'    => 'prioritiesList',
        ]);
    }
}
