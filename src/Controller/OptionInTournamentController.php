<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AbstractClass\CustomAbstractController;
use App\Dto\OptionInTournamentDto;
use App\Dto\VoteDto;
use App\Entity\OptionInTournament;
use App\Entity\Tournament;
use App\Entity\Vote;
use App\Form\OptionInTournamentType;
use App\Form\VoteType;
use App\Repository\VoteRepository;
use App\Service\VoteService;
use App\Util\FlashBag\MessageFactory;
use App\Util\Mapper\Mapper;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 * Class OptionInTournamentController
 * @package App\Controller
 */
class OptionInTournamentController extends CustomAbstractController
{
    /**
     * @var Mapper
     */
    private Mapper $mapper;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var VoteRepository
     */
    private VoteRepository $voteRepository;

    /**
     * OptionInTournamentController constructor.
     *
     * @param Mapper                 $mapper
     * @param EntityManagerInterface $entityManager
     * @param VoteRepository         $voteRepository
     */
    public function __construct(Mapper $mapper, EntityManagerInterface $entityManager, VoteRepository $voteRepository)
    {
        $this->mapper = $mapper;
        $this->entityManager = $entityManager;
        $this->voteRepository = $voteRepository;
    }

    /**
     * @Route("option-in-tournament/{id}", name="option-in-tournament-show", requirements={"id"="\d+"})
     * @param Request            $request
     * @param OptionInTournament $optionInTournament
     * @param VoteService        $voteService
     *
     * @return Response
     * @throws NonUniqueResultException
     * @throws UnregisteredMappingException
     */
    public function show(Request $request, OptionInTournament $optionInTournament, VoteService $voteService): Response
    {
        $prioritiesList = $voteService->getListOfPrioritiesToVote($optionInTournament->getIdTournament());
        $votePriority = $this->voteRepository->getVotePriority($this->getUser(), $optionInTournament)->getOneOrNullResult();

        if (!empty($prioritiesList) && !$votePriority) {

            $voteDto = new VoteDto();

            $form = $this->createForm(VoteType::class, $voteDto, [
                'prioritiesList' => $prioritiesList,
            ]);
            $form->handleRequest($request);

            //Vote submission
            if ($form->isSubmitted() && $form->isValid()) {
                $this->get("security.csrf.token_manager")->refreshToken("form_intention");
                /** @var Vote $newVote */
                $newVote = $this->mapper->map($voteDto, Vote::class);
                $newVote
                    ->setIdOptionInTournament($optionInTournament)
                    ->setIdUser($this->getUser());

                try {
                    $this->entityManager->persist($newVote);
                    $this->entityManager->flush();
                    $this->addFlash('success', MessageFactory::getMessage('MESSAGE_SUCCESSFULLY_VOTED'));
                } catch (Exception $ex) {
                    $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_IT_WAS_NOT_POSSIBLE_TO_VOTE'));
                }

                return $this->redirectToRoute('option-in-tournament-show', [
                    'id' => $optionInTournament->getId(),
                ]);
            }
            return $this->render('option_in_tournament/show.html.twig', [
                'optionInTournament' => $optionInTournament,
                'form'               => $form->createView(),
            ]);
        }


        if ($votePriority) {
            return $this->render('option_in_tournament/show.html.twig', [
                'optionInTournament' => $optionInTournament,
                'votePriority'       => $votePriority,
            ]);
        }

        return $this->render('option_in_tournament/show.html.twig', [
            'optionInTournament' => $optionInTournament,
        ]);
    }

    /**
     * @Route("tournament/{tournament}/new-option", name="option-in-tournament-new", requirements={"tournament"="\d+"})
     * @param Request    $request
     * @param Tournament $tournament
     *
     * @return RedirectResponse|Response
     * @throws UnregisteredMappingException
     */
    public function new(Request $request, Tournament $tournament)
    {
        $optionInTournamentDto = new OptionInTournamentDto();

        $form = $this->createForm(OptionInTournamentType::class, $optionInTournamentDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var OptionInTournament $optionInTournament */
            $optionInTournamentDto->setIdUser($this->getUser()->getId());
            $optionInTournamentDto->setIdTournament($tournament->getId());
            $optionInTournament = $this->mapper->map($optionInTournamentDto, OptionInTournament::class);

            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($optionInTournament);
                $entityManager->flush();

                $this->addFlash('success', MessageFactory::getMessage('MESSAGE_NEW_SUCCESS'));

                return $this->redirectToRoute('option-in-tournament-show', ['id' => $optionInTournament->getId()]);
            } catch (Exception $ex) {
                $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_NEW_FAILURE'));
            }

            return $this->redirectToRoute('tournament', [
                'id' => $tournament->getId(),
            ]);
        }

        return $this->render('option_in_tournament/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("option-in-tournament/{id}/edit/", name="option-in-tournament-edit", requirements={"tournament"="\d+"})
     * @param Request            $request
     * @param OptionInTournament $optionInTournament
     *
     * @return RedirectResponse|Response
     * @throws UnregisteredMappingException
     */
    public function edit(Request $request, OptionInTournament $optionInTournament)
    {
        /** @var OptionInTournamentDto $optionInTournamentDto */
        $optionInTournamentDto = $this->mapper->map($optionInTournament, OptionInTournamentDto::class);

        $form = $this->createForm(OptionInTournamentType::class, $optionInTournamentDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get("security.csrf.token_manager")->refreshToken("form_intention");

            /** @var OptionInTournament $optionInTournamentValid */
            $optionInTournamentValid = $this->mapper->mapToObject($optionInTournamentDto, $optionInTournament);
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($optionInTournamentValid);
                $entityManager->flush();

                $this->addFlash('success', MessageFactory::getMessage('MESSAGE_EDIT_SUCCESS', $optionInTournament->getId()));
            } catch (Exception $ex) {
                $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_EDIT_FAILURE', $optionInTournament->getId()));
            }

            return $this->redirectToRoute('option-in-tournament-show', ['id' => $optionInTournament->getId()]);
        }

        return $this->render('option_in_tournament/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
