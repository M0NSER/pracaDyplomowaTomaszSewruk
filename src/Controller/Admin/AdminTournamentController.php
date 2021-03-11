<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Vote;
use App\Form\VoteAdminType;
use App\Repository\OptionInTournamentRepository;
use App\Repository\TournamentCodeRepository;
use App\Repository\TournamentRepository;
use App\Repository\TournamentUserRepository;
use App\Repository\VoteRepository;
use App\Util\FlashBag\MessageFactory;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class AdminTournamentController
 * @package App\Controller\Admin
 */
class AdminTournamentController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @Route("/tournament", name="admin-tournament")
     * @param Request              $request
     * @param TournamentRepository $tournamentRepository
     *
     * @return Response
     */
    public function tournament(Request $request, TournamentRepository $tournamentRepository): Response
    {
        $query = $tournamentRepository->findAllTournamentAdmin();

        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10,
            [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 't.createAt',
                PaginatorInterface::DEFAULT_SORT_DIRECTION  => 'desc',
            ]
        );

        return $this->render('admin/tournament/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/option-in-tournament", name="admin-option-in-tournament")
     * @param Request                      $request
     * @param OptionInTournamentRepository $optionInTournamentRepository
     *
     * @return Response
     */
    public function optionInTournament(Request $request, OptionInTournamentRepository $optionInTournamentRepository): Response
    {
        $query = $optionInTournamentRepository->findAllOptionInTournamentAdmin();

        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10,
            [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'oit.createAt',
                PaginatorInterface::DEFAULT_SORT_DIRECTION  => 'desc',
            ]
        );

        return $this->render('admin/option_in_tournament/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/tournament-user", name="admin-tournament-user")
     * @param Request                  $request
     * @param TournamentUserRepository $tournamentUserRepository
     *
     * @return Response
     */
    public function tournamentUser(Request $request, TournamentUserRepository $tournamentUserRepository): Response
    {
        $query = $tournamentUserRepository->findAllTournamentUserAdmin();

        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10,
            [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'tu.createAt',
                PaginatorInterface::DEFAULT_SORT_DIRECTION  => 'desc',
            ]
        );

        return $this->render('admin/tournament-user/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/vote", name="admin-vote")
     * @param Request        $request
     * @param VoteRepository $voteRepository
     *
     * @return Response
     */
    public function vote(Request $request, VoteRepository $voteRepository): Response
    {
        $query = $voteRepository->findAllVoteAdmin();

        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10,
            [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'v.createAt',
                PaginatorInterface::DEFAULT_SORT_DIRECTION  => 'desc',
            ]
        );

        return $this->render('admin/vote/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/vote/{id}/edit", name="admin-vote-edit", requirements={"id"="\d+"})
     * @param Request $request
     * @param Vote    $vote
     *
     * @return Response
     */
    public function voteEdit(Request $request, Vote $vote): Response
    {
        $votePriorityList = [];
        for ($i = 1; $i <= $vote->getIdOptionInTournament()->getIdTournament()->getVotesQuantity(); $i++) {
            $votePriorityList[] = $i;
        }

        $form = $this->createForm(VoteAdminType::class, $vote, ['priorityList' => $votePriorityList]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get("security.csrf.token_manager")->refreshToken("form_intention");

            $voteValid = $vote;
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($voteValid);
                $entityManager->flush();

                $this->addFlash('success', MessageFactory::getMessage('MESSAGE_EDIT_SUCCESS', $vote->getId()));
            } catch (Exception $ex) {
                $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_EDIT_FAILURE', $vote->getId()));
            }

            return $this->redirectToRoute('admin-vote');
        }

        return $this->render('admin/vote/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tournament-code", name="admin-tournament-code")
     * @param Request                  $request
     * @param TournamentCodeRepository $tournamentCodeRepository
     *
     * @return Response
     */
    public function tournamentCode(Request $request, TournamentCodeRepository $tournamentCodeRepository): Response
    {
        $query = $tournamentCodeRepository->findAllTournamentCodeAdmin();

        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10,
            [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'tc.createAt',
                PaginatorInterface::DEFAULT_SORT_DIRECTION  => 'desc',
            ]
        );

        return $this->render('admin/tournament-code/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }


}
