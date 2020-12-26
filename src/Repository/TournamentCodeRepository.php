<?php

namespace App\Repository;

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
    function findAllQuery(): Query
    {
        return $this->getBasicQuery()->getQuery();
    }
}
