<?php

namespace App\Controller;

use App\Controller\AbstractClass\CustomAbstractController;
use App\Dto\ModderSelectDto;
use App\Entity\OptionInTournament;
use App\Form\NotSelectedType;
use App\Form\SelectedVotesType;
use App\Repository\VoteRepository;
use App\Service\ModderSelectService;
use App\Service\TournamentPrivilegeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/modder-select/")
 * Class ModderSelectController
 * @package App\Controller
 */
class ModderSelectController extends CustomAbstractController
{
    /**
     * @var VoteRepository
     */
    private VoteRepository $voteRepository;

    /**
     * @var ModderSelectService
     */
    private ModderSelectService $modderSelectService;

    /**
     * @var TournamentPrivilegeService
     */
    private TournamentPrivilegeService $tournamentPrivilegeService;

    public function __construct(VoteRepository $voteRepository, ModderSelectService $modderSelectService, TournamentPrivilegeService $tournamentPrivilegeService)
    {
        $this->voteRepository = $voteRepository;
        $this->modderSelectService = $modderSelectService;
        $this->tournamentPrivilegeService = $tournamentPrivilegeService;
    }

    /**
     * @Route("option-in-tournament/{id}", name="modder-select", requirements={"id"="\d+"})
     * @param Request            $request
     * @param OptionInTournament $optionInTournament
     *
     * @return Response
     */
    public function index(Request $request, OptionInTournament $optionInTournament): Response
    {
        $this->tournamentPrivilegeService->hasPrivilegeToTournament($optionInTournament->getIdTournament(), [
            $this->getTournamentPrivilege()['T_ADMIN'],
            $this->getTournamentPrivilege()['T_MODDER'],
        ]);

        $notSelectedVotesDto = new ModderSelectDto();
        $selectedVotesDto = new ModderSelectDto();

        $notSelectedVotesFormOptions = [
            'votesInOptionInTournament' => $this->voteRepository->getNotSelectedVotesInOptionInTournament($optionInTournament)->getResult(),
        ];
        $selectedVotesFormOptions = [
            'votesInOptionInTournament' => $this->voteRepository->getSelectedVotesInOptionInTournament($optionInTournament)->getResult(),
        ];
        $notSelectedVotesForm = $this->createForm(NotSelectedType::class, $notSelectedVotesDto, $notSelectedVotesFormOptions);
        $notSelectedVotesForm->handleRequest($request);

        $selectedVotesForm = $this->createForm(SelectedVotesType::class, $selectedVotesDto, $selectedVotesFormOptions);
        $selectedVotesForm->handleRequest($request);

        if ($notSelectedVotesForm->isSubmitted() && $notSelectedVotesForm->isValid()) {
            $this->get("security.csrf.token_manager")
                ->refreshToken("form_intention");

            $this->modderSelectService
                ->setAsSelectedByModder($notSelectedVotesDto->getVotesInOptionInTournament());

            return $this->redirectToRoute('modder-select', [
                'id' => $optionInTournament->getId(),
            ]);
        }

        if ($selectedVotesForm->isSubmitted() && $selectedVotesForm->isValid()) {
            $this->get("security.csrf.token_manager")
                ->refreshToken("form_intention");

            $this->modderSelectService
                ->setAsNotSelectedByModder($selectedVotesDto->getVotesInOptionInTournament());

            return $this->redirectToRoute('modder-select', [
                'id' => $optionInTournament->getId(),
            ]);
        }

        return $this->render('modder_select/index.html.twig', [
            'optionInTournament'    => $optionInTournament,
            'notSelectedVotesForm'  => $notSelectedVotesForm->createView(),
            'selectedVotesForm'     => $selectedVotesForm->createView(),
            'countNotSelectedVotes' => count($notSelectedVotesFormOptions['votesInOptionInTournament']),
            'countSelectedVotes'    => count($selectedVotesFormOptions['votesInOptionInTournament']),
        ]);
    }
}
