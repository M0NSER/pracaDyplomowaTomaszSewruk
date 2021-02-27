<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Tournament;
use App\Repository\TournamentUserRepository;
use App\Util\FlashBag\MessageFactory;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TournamentPrivilegeService
{
    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @var array
     */
    private array $tournamentPrivilege;

    /**
     * @var TournamentUserRepository
     */
    private TournamentUserRepository $tournamentUserRepository;

    /**
     * @var UserInterface|null
     */
    private ?UserInterface $loggedInUser;

    public function __construct(EntityManager $entityManager, array $tournamentPrivilege, TournamentUserRepository $tournamentUserRepository, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tournamentPrivilege = $tournamentPrivilege;
        $this->tournamentUserRepository = $tournamentUserRepository;

        $token = $tokenStorage->getToken();
        if ($token && $token->getUser()) {
            $this->loggedInUser = $token->getUser();
        }
    }

    /**
     * @param Tournament $tournament
     * @param array      $tournamentUserRoles
     *
     * @return mixed
     */
    public function hasPrivilegeToTournament(Tournament $tournament, array $tournamentUserRoles = [])
    {
        $tournamentUser = $this->tournamentUserRepository->findOneBy([
            'idUser'       => $this->loggedInUser,
            'idTournament' => $tournament,
        ]);

        if (!$tournamentUser || !in_array($tournamentUser->getTournamentUserType(), $tournamentUserRoles)) {
            throw new UnauthorizedHttpException('', MessageFactory::getMessage('MESSAGE_YOU_HAVE_NO_PERMISSION'));
        }
    }
}