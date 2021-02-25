<?php

namespace App\Controller;

use App\Controller\AbstractClass\CustomAbstractController;
use App\Dto\AddUserToTournamentDto;
use App\Entity\Tournament;
use App\Entity\TournamentUser;
use App\Form\AddUserToTournamentType;
use App\Repository\TournamentUserRepository;
use App\Repository\UserRepository;
use App\Service\TournamentUserService;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TournamentUserController
 * @package App\Controller
 */
class TournamentUserController extends CustomAbstractController
{
    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * @var TournamentUserRepository
     */
    private TournamentUserRepository $tournamentUserRepository;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var TournamentUserService
     */
    private TournamentUserService $tournamentUserService;

    /**
     * TournamentUserController constructor.
     *
     * @param PaginatorInterface       $paginator
     * @param TournamentUserRepository $tournamentUserRepository
     * @param UserRepository           $userRepository
     * @param TournamentUserService    $tournamentUserService
     */
    public function __construct(
        PaginatorInterface $paginator,
        TournamentUserRepository $tournamentUserRepository,
        UserRepository $userRepository,
        TournamentUserService $tournamentUserService)
    {
        $this->paginator = $paginator;
        $this->tournamentUserRepository = $tournamentUserRepository;
        $this->userRepository = $userRepository;
        $this->tournamentUserService = $tournamentUserService;
    }

    /**
     * @Route("/tournament/{tournament}/tournament-user/", name="tournament-user", requirements={"tournament"="\d+"})
     * @param Request    $request
     * @param Tournament $tournament
     *
     * @return Response
     * @throws Exception
     */
    public function index(Request $request, Tournament $tournament): Response
    {
        // TODO: co jeśli użytkownik już jest w konkursie

        $userDto = new AddUserToTournamentDto();

        $addUserForm = $this->createForm(AddUserToTournamentType::class, $userDto);
        $addUserForm->handleRequest($request);

        $foundUsers = null;
        if ($addUserForm->isSubmitted() && $addUserForm->isValid()) {
            $this->get("security.csrf.token_manager")->refreshToken("form_intention");
            $this->tournamentUserService->addUsers($addUserForm->get('usersToAdd')->getData(), $tournament);

            return $this->redirectToRoute('tournament-user', ['tournament' => $tournament->getId()]);
        }

        if ($request->query->getBoolean('showDeleted') == false) {
            $query = $this->tournamentUserRepository->findAllUserInTournament($tournament);
        } else {
            $query = $this->tournamentUserRepository->findAllDeletedUserInTournament($tournament);
        }

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10,
            [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'tu.createAt',
                PaginatorInterface::DEFAULT_SORT_DIRECTION  => 'desc',
            ]
        );

        return $this->render('tournament_user/index.html.twig', [
            'tournament'  => $tournament,
            'pagination'  => $pagination,
            'addUserForm' => $addUserForm->createView(),
        ]);
    }

    /**
     * @Route("/tournament-user/{id}/delete", name="tournament-user-delete", requirements={"id"="\d+"})
     * @param TournamentUser $tournamentUser
     *
     * @return RedirectResponse
     */
    public function delete(TournamentUser $tournamentUser): RedirectResponse
    {
        $this->tournamentUserService->delete($tournamentUser);

        return $this->redirectToRoute('tournament-user', [
            'tournament' => $tournamentUser->getIdTournament()->getId(),
        ]);
    }

    /**
     * @Route("/tournament-user/{id}/set-privilege/{privilege}", name="tournament-user-set-privilege", requirements={"id"="\d+", "privilege"="T_VOTER|T_MODDER|T_ADMIN|T_DELETED"})
     * @param TournamentUser $tournamentUser
     * @param string         $privilege
     *
     * @return RedirectResponse
     */
    public function setPrivilege(TournamentUser $tournamentUser, string $privilege): RedirectResponse
    {
        $this->tournamentUserService->setPrivilege($tournamentUser, $privilege);

        return $this->redirectToRoute('tournament-user', [
            'tournament' => $tournamentUser->getIdTournament()->getId(),
        ]);
    }


}

