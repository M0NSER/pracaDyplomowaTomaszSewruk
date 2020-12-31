<?php

namespace App\Controller;

use App\Dto\TournamentDto;
use App\Entity\Tournament;
use App\Entity\TournamentUser;
use App\Form\TournamentType;
use App\Repository\TournamentRepository;
use App\Util\FlashBag\MessageFactory;
use App\Util\Mapper\Mapper;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class TournamentController
 * @package App\Controller
 * @Route("tournament")
 */
class TournamentController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * @var TournamentRepository
     */
    private TournamentRepository $tournamentRepository;

    private Mapper $mapper;

    /**
     * TournamentController constructor.
     *
     * @param PaginatorInterface   $paginator
     * @param TournamentRepository $tournamentRepository
     * @param Mapper               $mapper
     */
    public function __construct(PaginatorInterface $paginator, TournamentRepository $tournamentRepository, Mapper $mapper)
    {
        $this->paginator = $paginator;
        $this->tournamentRepository = $tournamentRepository;
        $this->mapper = $mapper;
    }

    /**
     * @Route("/", name="tournament")
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $query = $this->tournamentRepository->findAllMyTournament($this->getUser());

        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6, [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 't.createAt',
                PaginatorInterface::DEFAULT_SORT_DIRECTION => 'desc',
            ]
        );

        return $this->render('tournament/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/{id}", name="tournament-show")
     * @param Tournament $tournament
     * @param Request    $request
     *
     * @return Response
     */
    public function show(Tournament $tournament, Request $request)
    {
        $query = $this->tournamentRepository->findAllOptionsInTournament($tournament);

        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12, [
                PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'oit.id',
                PaginatorInterface::DEFAULT_SORT_DIRECTION => 'asc',
            ]
        );

        return $this->render('tournament/show.html.twig', [
            'tournament' => $tournament,
            'pagination' => $pagination,
        ]);
    }


    /**
     * @Route("-new", name="tournament-new")
     * @param Request $request
     *
     * @return Response
     * @throws UnregisteredMappingException
     */
    public function new(Request $request)
    {
        $tournamentDto = new TournamentDto();

        $form = $this->createForm(TournamentType::class, $tournamentDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Tournament $tournament */
            $tournament = $this->mapper->map($tournamentDto, Tournament::class);
            try {
                $t_admin = new TournamentUser();
                $t_admin->setIdTournament($tournament);
                $t_admin->setIdUser($this->getUser());
                $t_admin->setTournamentUserType($this->getParameter('T_ADMIN'));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($t_admin);
                $entityManager->persist($tournament);
                $entityManager->flush();

                $this->addFlash('success', MessageFactory::getMessage('MESSAGE_NEW_SUCCESS'));

                return $this->redirectToRoute('tournament');
            } catch (Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
                $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_NEW_FAILURE'));
            }

            return $this->redirectToRoute('tournament');
        }

        return $this->render('tournament/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("-edit/{id}", name="tournament-edit")
     * @param Request    $request
     * @param Tournament $tournament
     *
     * @return RedirectResponse|Response
     * @throws UnregisteredMappingException
     */
    public function edit(Request $request, Tournament $tournament)
    {
        $tournamentDto = $this->mapper->map($tournament, TournamentDto::class);

        $form = $this->createForm(TournamentType::class, $tournamentDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Tournament $tournament */
            $tournament = $this->mapper->map($tournamentDto, Tournament::class);
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($tournament);
                $entityManager->flush();

                $this->addFlash('success', MessageFactory::getMessage('MESSAGE_EDIT_SUCCESS'));

                return $this->redirectToRoute('tournament-show', [
                    'id' => $tournament->getId(),
                ]);
            } catch (Exception $ex) {
                $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_EDIT_FAILURE'));
            }

            return $this->redirectToRoute('tournament');
        }

        return $this->render('tournament/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("-delete/{id}", name="tournament-delete")
     * @param Tournament $tournament
     *
     * @return RedirectResponse
     */
    public function delete(Tournament $tournament){
        try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($tournament);
                $entityManager->flush();
                $this->addFlash('success', MessageFactory::getMessage('MESSAGE_DELETE_SUCCESS'));

                return $this->redirectToRoute('tournament');

        } catch (Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
            $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_DELETE_FAILURE'));
        }

        return $this->redirectToRoute('tournament');
    }
}