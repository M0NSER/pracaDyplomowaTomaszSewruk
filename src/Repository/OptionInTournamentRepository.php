<?php

namespace App\Repository;

use App\Entity\OptionInTournament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OptionInTournament|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionInTournament|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionInTournament[]    findAll()
 * @method OptionInTournament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionInTournamentRepository extends ServiceEntityRepository
{
    /**
     * OptionInTournamentRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionInTournament::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getBasicQuery(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('oit');
    }

    /**
     * @return Query
     */
    public function findAllQuery(): Query
    {
        return $this->getBasicQuery()->getQuery();
    }

    public function findAllOptionInTournamentAdmin()
    {
        return $this
            ->getBasicQuery()
            ->select('oit')
            ->getQuery();
    }
}
