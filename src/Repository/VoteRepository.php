<?php

namespace App\Repository;

use App\Entity\OptionInTournament;
use App\Entity\User;
use App\Entity\Vote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vote[]    findAll()
 * @method Vote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteRepository extends ServiceEntityRepository
{
    /**
     * VoteRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vote::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getBasicQuery(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('v');
    }

    /**
     * @return Query
     */
    public function findAllQuery(): Query
    {
        return $this->getBasicQuery()->getQuery();
    }

    /**
     * @param User               $user
     * @param OptionInTournament $optionInTournament
     *
     * @return Query
     */
    public function getVotePriority(User $user, OptionInTournament $optionInTournament): Query
    {
        return $this->_em->createQueryBuilder()
            ->select('vs')
            ->from(Vote::class, 'vs')
            ->andWhere('vs.idUser = :user')
            ->setParameter('user', $user->getId())
            ->andWhere('vs.idOptionInTournament = :idOptionInTournament')
            ->setParameter('idOptionInTournament', $optionInTournament->getId())
            ->setMaxResults(1)
            ->getQuery();
    }

    /**
     * @param OptionInTournament $optionInTournament
     *
     * @return Query
     */
    public function getNotSelectedVotesInOptionInTournament(OptionInTournament $optionInTournament): Query
    {
        return $this->getBasicQuery()
            ->andWhere('v.idOptionInTournament = :oit')
            ->setParameter('oit', $optionInTournament->getId())
            ->andWhere('v.isSelectedByPromoter = :isSelectedByPromoter')
            ->setParameter('isSelectedByPromoter', false)
            ->getQuery();
    }

    /**
     * @param OptionInTournament $optionInTournament
     *
     * @return Query
     */
    public function getSelectedVotesInOptionInTournament(OptionInTournament $optionInTournament): Query
    {
        return $this->getBasicQuery()
            ->andWhere('v.idOptionInTournament = :oit')
            ->setParameter('oit', $optionInTournament->getId())
            ->andWhere('v.isSelectedByPromoter = :isSelectedByPromoter')
            ->setParameter('isSelectedByPromoter', true)
            ->getQuery();
    }

    /**
     * @param OptionInTournament $optionInTournament
     *
     * @return Query
     */
    public function getCountSelectedVotesInOptionInTournament(OptionInTournament $optionInTournament): Query
    {
        return $this->_em->createQueryBuilder()
            ->select('COUNT(v.id)')
            ->from(Vote::class, 'v')
            ->andWhere('v.idOptionInTournament = :oit')
            ->setParameter('oit', $optionInTournament->getId())
            ->andWhere('v.isSelectedByPromoter = :isSelectedByPromoter')
            ->setParameter('isSelectedByPromoter', true)
            ->getQuery();
    }

    /**
     * @return Query
     */
    public function findAllVoteAdmin(): Query
    {
        return $this->getBasicQuery()
            ->select('v')
            ->addSelect('oit')
            ->addSelect('t')
            ->leftJoin('v.idOptionInTournament', 'oit')
            ->leftJoin('oit.idTournament', 't')
            ->addOrderBy('t.createAt', 'DESC')
            ->addOrderBy('oit.id', 'ASC')
            ->getQuery();
    }
}
