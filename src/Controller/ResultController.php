<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Repository\TournamentRepository;
use App\Repository\TournamentUserRepository;
use App\Repository\VoteRepository;
use App\Util\FlashBag\MessageFactory;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/result/")
 * Class ResultController
 * @package App\Controller
 */
class ResultController extends AbstractController
{
    /**
     * @var VoteRepository
     */
    private VoteRepository $voteRepository;

    /**
     * @var TournamentUserRepository
     */
    private TournamentUserRepository $tournamentUserRepository;

    /**
     * @var TournamentRepository
     */
    private TournamentRepository $tournamentRepository;

    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    public function __construct(VoteRepository $voteRepository, TournamentUserRepository $tournamentUserRepository, TournamentRepository $tournamentRepository, PaginatorInterface $paginator)
    {
        $this->voteRepository = $voteRepository;
        $this->tournamentUserRepository = $tournamentUserRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->paginator = $paginator;
    }

    /**
     * @Route("{id}", name="result", requirements={"id"="\d+"})
     * @param Request    $request
     * @param Tournament $tournament
     *
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request, Tournament $tournament): Response
    {
        $privilege = $this->tournamentUserRepository->getUserPrivilegeInTournament($tournament, $this->getUser())->getSingleScalarResult();

        if ($privilege == $this->getParameter('T_VOTER')) {
            $result = $this->tournamentRepository->getResultForVoter($tournament, $this->getUser())->getOneOrNullResult();

            return $this->render('result/voter_index.html.twig', [
                'result' => $result,
            ]);
        } else if ($privilege == $this->getParameter('T_ADMIN') || $privilege == $this->getParameter('T_MODDER')) {
            $query = $this->tournamentRepository->getResultForModder($tournament)->getResult();

            $pagination = $this->paginator->paginate(
                $query,
                $request->query->getInt('page', 1)/*page number*/,
                10,
                [
                    PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 't.createAt',
                    PaginatorInterface::DEFAULT_SORT_DIRECTION  => 'desc',
                ]
            );

            return $this->render('result/modder_index.html.twig', [
                'pagination'     => $pagination,
                'tournamentInfo' => $tournament,
            ]);
        }
        $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_YOU_HAVE_NO_PERMISSION'));

        return $this->redirectToRoute('main');
    }
}
