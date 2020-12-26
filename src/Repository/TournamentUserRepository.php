<?php

namespace App\Repository;

use App\Entity\TournamentUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

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
    function findAllQuery(): Query
    {
        return $this->getBasicQuery()->getQuery();
    }
}