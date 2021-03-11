<?php

namespace App\Repository;

use App\Entity\Tournament;
use App\Entity\TournamentCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TournamentCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method TournamentCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method TournamentCode[]    findAll()
 * @method TournamentCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentCodeRepository extends ServiceEntityRepository
{
    /**
     * TournamentCodeRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TournamentCode::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getBasicQuery(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('tc');
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
    public function getCodeForTournament(Tournament $tournament): Query
    {
        return $this->getBasicQuery()
            ->select('tc')
            ->andWhere('tc.idTournament = :idTournament')
            ->setParameter('idTournament', $tournament->getId())
            ->andWhere($this->getBasicQuery()->expr()->orX(
                $this->getBasicQuery()->expr()->gt('tc.expireAt', 'CURRENT_TIMESTAMP()'),
                $this->getBasicQuery()->expr()->isNull('tc.expireAt')
            ))
            ->getQuery();
    }

    /**
     * @param string $queryCode
     *
     * @return Query
     */
    public function getCodeByQuery(string $queryCode): Query
    {
        return $this->getBasicQuery()
            ->select('tc')
            ->andWhere('tc.generatedCode = :queryCode')
            ->setParameter('queryCode', $queryCode)
            ->andWhere($this->getBasicQuery()->expr()->orX(
                $this->getBasicQuery()->expr()->gt('tc.expireAt', 'CURRENT_TIMESTAMP()'),
                $this->getBasicQuery()->expr()->isNull('tc.expireAt')
            ))
            ->andWhere('tc.deletedAt is NULL')
            ->getQuery();
    }

    /**
     * @return Query
     */
    public function findAllTournamentCodeAdmin(): Query
    {
        return $this->getBasicQuery()
            ->select('tc')
            ->addSelect('t')
            ->leftJoin('tc.idTournament', 't')
            ->getQuery();
    }
}
