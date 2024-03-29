<?php

namespace App\Repository;

use App\Entity\Tournament;
use App\Entity\TournamentUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method TournamentUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TournamentUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TournamentUser[]    findAll()
 * @method TournamentUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentUserRepository extends ServiceEntityRepository
{
    /**
     * TournamentUserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TournamentUser::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getBasicQuery(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('tu');
    }

    /**
     * @return Query
     */
    public function findAllQuery(): Query
    {
        return $this->getBasicQuery()->getQuery();
    }

    /**
     * @param Tournament $tournament
     *
     * @return Query
     */
    public function findAllUserInTournament(Tournament $tournament): Query
    {
        return $this->getBasicQuery()
            ->select('tu')
            ->andWhere('tu.idTournament = :tournamentId')
            ->setParameter('tournamentId', $tournament->getId())
            ->andWhere('tu.tournamentUserType != :userType')
            ->setParameter('userType', 'T_DELETED')
            ->orderBy('tu.createAt', 'DESC')
            ->addOrderBy('tu.updateAt', 'DESC')
            ->getQuery();
    }

    /**
     * @param Tournament $tournament
     *
     * @return Query
     */
    public function findAllDeletedUserInTournament(Tournament $tournament): Query
    {
        return $this->getBasicQuery()
            ->select('tu')
            ->andWhere('tu.idTournament = :tournamentId')
            ->setParameter('tournamentId', $tournament->getId())
            ->andWhere('tu.tournamentUserType = :userType')
            ->setParameter('userType', 'T_DELETED')
            ->orderBy('tu.createAt', 'DESC')
            ->addOrderBy('tu.updateAt', 'DESC')
            ->getQuery();
    }

    /**
     * @param Tournament    $tournament
     * @param UserInterface $user
     *
     * @return Query
     */
    public function getUserPrivilegeInTournament(Tournament $tournament, UserInterface $user): Query
    {
        return $this->getBasicQuery()
            ->select('tu.tournamentUserType')
            ->andWhere('tu.idTournament = :idTournament')
            ->setParameter('idTournament', $tournament->getId())
            ->andWhere('tu.idUser = :idUser')
            ->setParameter('idUser', $user->getId())
            ->getQuery();
    }

    /**
     * @return Query
     */
    public function findAllTournamentUserAdmin(): Query
    {
        return $this->getBasicQuery()
            ->select('tu')
            ->getQuery();
    }
}
