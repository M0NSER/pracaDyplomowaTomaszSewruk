<?php

namespace App\Controller;

use App\Dto\AddUserToTournamentDto;
use App\Entity\Tournament;
use App\Entity\TournamentUser;
use App\Form\AddUserToTournamentType;
use App\Repository\TournamentUserRepository;
use App\Repository\UserRepository;
use App\Util\FlashBag\MessageFactory;
use Doctrine\ORM\EntityManager;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TournamentUserController
 * @package App\Controller
 */
class TournamentUserController extends AbstractController
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
     * TournamentUserController constructor.
     *
     * @param PaginatorInterface       $paginator
     * @param TournamentUserRepository $tournamentUserRepository
     * @param UserRepository           $userRepository
     */
    public function __construct(
        PaginatorInterface $paginator,
        TournamentUserRepository $tournamentUserRepository,
        UserRepository $userRepository)
    {
        $this->paginator = $paginator;
        $this->tournamentUserRepository = $tournamentUserRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/tournament/{tournament}/tournament-user", name="tournament-user", requirements={"tournament"="\d+"})
     * @param Request    $request
     * @param Tournament $tournament
     *
     * @return Response
     */
    public function index(Request $request, Tournament $tournament): Response
    {
        // TODO: co jeśli użytkownik już jest w konkursie

        $userDto = new AddUserToTournamentDto();
        $addUserForm = $this->createForm(AddUserToTournamentType::class, $userDto);
        $addUserForm->handleRequest($request);

        $foundUsers = null;
        if ($addUserForm->isSubmitted() && $addUserForm->isValid()) {
            $newTournamentUser = new TournamentUser();
            $newTournamentUser->setIdUser($addUserForm->get('userFindField')->getData());
            $newTournamentUser->setIdTournament($tournament);
            $newTournamentUser->setTournamentUserType($this->getParameter('T_VOTER'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newTournamentUser);
            $entityManager->flush();

            $this->redirectToRoute('tournament-user', ['tournament' => $tournament->getId()]);
        }

        $query = $this->tournamentUserRepository->findAllUserInTournament($tournament);

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10,
            [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'tu.createAt',
                PaginatorInterface::DEFAULT_SORT_DIRECTION => 'desc',
            ]
        );

        return $this->render('tournament_user/index.html.twig', [
            'pagination' => $pagination,
            'addUserForm' => $addUserForm->createView(),
        ]);
    }

    /**
     * @Route("/tournament-user/delete/{id}", name="tournament-user-delete", requirements={"id"="\d+"})
     * @param TournamentUser $tournamentUser
     *
     * @return RedirectResponse
     */
    public function delete(TournamentUser $tournamentUser)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $tournamentUser->setTournamentUserType($this->getParameter('T_DELETED'));
            $entityManager->persist($tournamentUser);
            $entityManager->flush();
            $entityManager->remove($tournamentUser);
            $entityManager->flush();
            $this->addFlash('success', MessageFactory::getMessage('MESSAGE_DELETE_SUCCESS'));
        } catch (Exception $ex) {
            $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_DELETE_FAILURE'));
        }

        return $this->redirectToRoute('tournament-user', ['tournament' => $tournamentUser->getIdTournament()->getId()]);

    }


}

