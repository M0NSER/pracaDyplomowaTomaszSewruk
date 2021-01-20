<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Tournament;
use App\Entity\TournamentUser;
use App\Entity\User;
use App\Repository\TournamentUserRepository;
use App\Util\FlashBag\MessageFactory;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;


class TournamentUserService
{
    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @var array
     */
    private array $rawTournamentPrivilege;

    /**
     * @var array
     */
    private array $tournamentPrivilege;

    /**
     * @var FlashBag
     */
    private FlashBag $flashBag;

    /**
     * @var TournamentUserRepository
     */
    private TournamentUserRepository $tournamentUserRepository;

    public function __construct(EntityManager $entityManager, array $tournamentPrivilege, array $rawTournamentPrivilege, TournamentUserRepository $tournamentUserRepository, FlashBag $flashBag)
    {
        $this->entityManager = $entityManager;
        $this->tournamentPrivilege = $tournamentPrivilege;
        $this->rawTournamentPrivilege  = $rawTournamentPrivilege;
        $this->flashBag = $flashBag;
        $this->tournamentUserRepository = $tournamentUserRepository;
    }

    /**
     * @param array      $users
     * @param Tournament $tournament
     *
     * @throws Exception
     */
    public function addUsers(array $users, Tournament $tournament)
    {
        $existingUser = 0;

        $distinctUsers = array_unique($users);

        foreach ($distinctUsers as $user) {
            $userCheck = $this->tournamentUserRepository->findBy([
                'idUser'       => $user,
                'idTournament' => $tournament,
            ]);

            if (!$userCheck) {
                /** @var User $user */
                $tournamentUser = new TournamentUser();
                $tournamentUser
                    ->setIdUser($user)
                    ->setIdTournament($tournament)
                    ->setTournamentUserType($this->tournamentPrivilege['T_VOTER']);

                try {
                    $this->entityManager->persist($tournamentUser);
                } catch (Exception $e) {
                    $this->flashBag->add('danger', MessageFactory::getMessage('MESSAGE_CAN_NOT_ADD_USER_TO_TOURNAMENT'));
                }
            } else {
                $existingUser++;
            }
        }
        try {
            $this->entityManager->flush();

            if ($existingUser > 0) {
                $this->flashBag->add('warning', MessageFactory::getMessage('MESSAGE_SOME_USERS_ALREADY_EXISTS'));
            }
            if ($existingUser < sizeof($distinctUsers)) {
                $this->flashBag->add('success', MessageFactory::getMessage('MESSAGE_USER_SUCCESSFULLY_ADDED', sizeof($distinctUsers) - $existingUser));
            }
        } catch (Exception $ex) {
            $this->flashBag->add('danger', MessageFactory::getMessage('MESSAGE_CAN_NOT_ADD_USER_TO_TOURNAMENT'));
        }
    }

    /**
     * @param TournamentUser $tournamentUser
     */
    public function delete(TournamentUser $tournamentUser)
    {
        try {
            $tournamentUser->setTournamentUserType($this->tournamentPrivilege['T_DELETED']);

            $this->entityManager->persist($tournamentUser);
            $this->entityManager->flush();
            $this->entityManager->remove($tournamentUser);
            $this->entityManager->flush();
            $this->flashBag->add('success', MessageFactory::getMessage('MESSAGE_DELETE_SUCCESS'));
        } catch (Exception $ex) {
            $this->flashBag->add('danger', MessageFactory::getMessage('MESSAGE_DELETE_FAILURE'));
        }
    }

    /**
     * @param TournamentUser $tournamentUser
     * @param string         $privilege
     */
    public function setPrivilege(TournamentUser $tournamentUser, string $privilege)
    {
        try {
            switch ($privilege) {
                case $this->tournamentPrivilege['T_ADMIN']:
                    $tournamentUser
                        ->setTournamentUserType($this->tournamentPrivilege['T_ADMIN']);
                    break;
                case $this->tournamentPrivilege['T_MODDER']:
                    $tournamentUser
                        ->setTournamentUserType($this->tournamentPrivilege['T_MODDER']);
                    break;
                case $this->tournamentPrivilege['T_VOTER']:
                    $tournamentUser
                        ->setTournamentUserType($this->tournamentPrivilege['T_VOTER']);
                    break;
            }
            $this->entityManager->persist($tournamentUser);
            $this->entityManager->flush();
            $this->flashBag->add('success', MessageFactory::getMessage('MESSAGE_PRIVILEGE_HAS_BEEN_CHANGER_FOR_USER',
                $this->rawTournamentPrivilege[$privilege], $tournamentUser->getIdUser()->getEmail(),
            ));
        } catch (Exception $ex) {
            $this->flashBag->add('danger', MessageFactory::getMessage('MESSAGE_PRIVILEGE_CAN_NOT_BE_CHANGED_FOR',
                $tournamentUser->getIdUser()->getEmail(),
            ));
        }
    }
}