<?php

namespace App\Controller;

use App\Controller\AbstractClass\CustomAbstractController;
use App\Entity\Tournament;
use App\Entity\TournamentCode;
use App\Entity\TournamentUser;
use App\Repository\TournamentCodeRepository;
use App\Repository\TournamentUserRepository;
use App\Util\FlashBag\MessageFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Polyfill\Uuid\Uuid;

/**
 * @Route("/code/")
 * Class CodeController
 * @package App\Controller
 */
class CodeController extends CustomAbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var TournamentCodeRepository
     */
    private TournamentCodeRepository $tournamentCodeRepository;

    /**
     * @var TournamentUserRepository
     */
    private TournamentUserRepository $tournamentUserRepository;

    /**
     * CodeController constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param TournamentCodeRepository $tournamentCodeRepository
     */
    public function __construct(EntityManagerInterface $entityManager, TournamentCodeRepository $tournamentCodeRepository, TournamentUserRepository $tournamentUserRepository)
    {
        $this->entityManager = $entityManager;
        $this->tournamentCodeRepository = $tournamentCodeRepository;
        $this->tournamentUserRepository = $tournamentUserRepository;
    }

    /**
     * @Route("add-user", name="add-user-by-code")
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws NonUniqueResultException
     */
    public function addUserToTournamentByCode(Request $request): RedirectResponse
    {
        $queryCode = (string)$request->query->get('tournament_code');

        /** @var TournamentCode $code */
        $code = $this->tournamentCodeRepository->getCodeByQuery($queryCode)->getOneOrNullResult();

        if (!$code) {
            $this->addFlash('warning', MessageFactory::getMessage('MESSAGE_THIS_CODE_DOES_NOT_EXIST_OR_IS_EXPIRED'));

            return $this->redirectToRoute('main');
        }

        if ($this->tournamentUserRepository->findOneBy([
            'idTournament' => $code->getIdTournament(),
            'idUser'       => $this->getUser(),
        ])) {
            $this->addFlash('warning', MessageFactory::getMessage('MESSAGE_YOU_ARE_ALREADY_IN_THIS_TOURNAMENT_OR_YOU_HAVE_BEEN_DELETED'));

            return $this->redirectToRoute('tournament-show', [
                'id' => $code->getIdTournament()->getId(),
            ]);
        }

        $tournamentUser = new TournamentUser();
        $tournamentUser
            ->setIdUser($this->getUser())
            ->setIdTournament($code->getIdTournament())
            ->setTournamentUserType($this->getParameter('tournament_privilege')['T_VOTER']);

        try {
            $this->entityManager->persist($tournamentUser);
            $this->entityManager->flush();

            $this->addFlash('success', MessageFactory::getMessage('MESSAGE_SUCCESSFULLY_ADDED_TO_TOURNAMENT'));

            return $this->redirectToRoute('tournament-show', [
                'id' => $code->getIdTournament()->getId(),
            ]);
        } catch (Exception $e) {
            $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_CAN_NOT_ADD_USER_TO_TOURNAMENT'));
        }

        return $this->redirectToRoute('main');
    }

    /**
     * @Route("tournament/{id}", name="generate-code", requirements={"id"="\d+"})
     * @param Tournament $tournament
     *
     * @return Response
     */
    public function generateCode(Tournament $tournament): Response
    {
        $existingCode = $this->tournamentCodeRepository->getCodeForTournament($tournament)->getResult();

        if ($existingCode) {
            foreach ($existingCode as $code) {
                $this->addFlash('secondary',MessageFactory::getMessage('MESSAGE_YOUR_CODE_IS', $code->getGeneratedCode()));
            }

            return $this->redirectToRoute('tournament-user', [
                'tournament' => $tournament->getId(),
            ]);
        }

        $uuidCode = new Uuid();
        $generatedCode = $uuidCode->uuid_create();

        $newCode = new TournamentCode();
        $newCode
            ->setGeneratedCode($generatedCode)
            ->setIdTournament($tournament);

        $this->entityManager->persist($newCode);
        $this->entityManager->flush();

        $this->addFlash('secondary', MessageFactory::getMessage('MESSAGE_YOUR_CODE_IS', $generatedCode));

        return $this->redirectToRoute('tournament-user', [
            'tournament' => $tournament->getId(),
        ]);
    }

}
