<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\OptionInTournament;
use App\Entity\Tournament;
use App\Entity\Vote;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function is_object;

class VoteService
{
    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @var UserInterface|string
     */
    private UserInterface $loggedInUser;

    /**
     * VoteService constructor.
     *
     * @param EntityManager         $entityManager
     * @param TokenStorageInterface $userStorage
     */
    public function __construct(EntityManager $entityManager, TokenStorageInterface $userStorage)
    {
        $this->entityManager = $entityManager;

        if (null === $token = $userStorage->getToken()) {
            throw new UnauthorizedHttpException('Unauthorized Exception');
        }

        if (!is_object($user = $token->getUser())) {
            throw new UnauthorizedHttpException('Unauthorized Exception');
        }

        $this->loggedInUser = $user;
    }

    /**
     * @param Tournament $tournament
     *
     * @return array
     */
    public function getListOfPrioritiesToVote(Tournament $tournament): array
    {
        $optionInTournamentArray = $this->entityManager->createQueryBuilder()
            ->select('oit.id')
            ->from(OptionInTournament::class, 'oit')
            ->where('oit.idTournament = :tournamentId')
            ->setParameter('tournamentId', $tournament->getId())
            ->getQuery()
            ->getArrayResult();

        /**
         * simplify array from
         *  egOptionInTournamentArray = [
         *      0=>[
         *              'id'=>321,
         *              'id'=>11,
         *          ],
         *      1=>[
         *              'id'=>211
         *          ]
         *      ]
         * to
         * egOptionInTournamentArray = [
         *      '0'=>321,
         *      '1'=>11,
         *      '2'=>211,
         * ]
         */
        $optionInTournamentIds = array_map(
            function ($item) {
                return $item['id'];
            },
            $optionInTournamentArray);


        $prioritiesFromVotesArray = $this->entityManager->createQueryBuilder()
            ->select('v.priority')
            ->from(Vote::class, 'v')
            ->andWhere('v.idOptionInTournament IN (:oitIds)')
            ->setParameter('oitIds', $optionInTournamentIds)
            ->andWhere('v.idUser = :idUser')
            ->setParameter('idUser', $this->loggedInUser->getId())
            ->getQuery()
            ->getResult();

        /**
         * simplify array from same as higher
         */
        $prioritiesFromVotes = array_map(
            function ($item) {
                return $item['priority'];
            },
            $prioritiesFromVotesArray);

        $emptyPrioritySlots = array_diff(range(1, $tournament->getVotesQuantity()), $prioritiesFromVotes);

        /**
         * reset indexes
         */
        return array_splice($emptyPrioritySlots, 0);
    }
}