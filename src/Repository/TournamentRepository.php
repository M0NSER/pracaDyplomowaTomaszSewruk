<?php

namespace App\Repository;

use App\Entity\OptionInTournament;
use App\Entity\Tournament;
use App\Entity\User;
use App\Entity\Vote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Tournament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournament[]    findAll()
 * @method Tournament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentRepository extends ServiceEntityRepository
{
    /**
     * @var TournamentUserRepository
     */
    private TournamentUserRepository $tournamentUserRepository;

    private OptionInTournamentRepository $optionInTournamentRepository;

    /**
     * TournamentRepository constructor.
     *
     * @param ManagerRegistry              $registry
     * @param TournamentUserRepository     $tournamentUserRepository
     * @param OptionInTournamentRepository $optionInTournamentRepository
     */
    public function __construct(ManagerRegistry $registry, TournamentUserRepository $tournamentUserRepository, OptionInTournamentRepository $optionInTournamentRepository)
    {
        parent::__construct($registry, Tournament::class);
        $this->tournamentUserRepository = $tournamentUserRepository;
        $this->optionInTournamentRepository = $optionInTournamentRepository;
    }

    /**
     * @return QueryBuilder
     */
    public function getBasicQuery(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('t');
    }

    /**
     * @return Query
     */
    function findAllQuery(): Query
    {
        return $this->getBasicQuery()->getQuery();
    }

    /**
     * @param UserInterface|null $user
     *
     * @return Query
     */
    function findAllMyTournament(?UserInterface $user): Query
    {
        $subQueryOption = $this->_em->createQueryBuilder()
            ->select('COUNT(oit.id)')
            ->from(OptionInTournament::class, 'oit')
            ->andWhere('oit.idTournament = tu.idTournament')
            ->getQuery()
            ->getDQL();

        /** @var User $user */
        return $this->tournamentUserRepository->getBasicQuery()
            ->select('partial tu.{id, tournamentUserType} as tournamentUser')
            ->addSelect('t')
            ->addSelect(sprintf("(%s) as options", $subQueryOption))
            ->leftJoin('tu.idTournament', 't')
            ->andWhere('tu.idUser = :idUser')
            ->setParameter('idUser', $user->getId())
            ->andWhere('t.deletedAt is NULL')
            ->andWhere('tu.tournamentUserType != :deletedUserType')
            ->setParameter('deletedUserType', 'T_DELETED')
            ->getQuery();

    }

    /**
     * @param Tournament    $tournament
     * @param UserInterface $user
     *
     * @return Query
     */
    public function findAllOptionsInTournament(Tournament $tournament, UserInterface $user): Query
    {
        $subQueryVoted = $this->_em->createQueryBuilder()
            ->select('v.priority')
            ->from(Vote::class, 'v')
            ->andWhere('v.idUser = :user')
            ->andWhere('v.idOptionInTournament = oit.id')
            ->getQuery()
            ->getDQL();

        return $this->_em->createQueryBuilder()
            ->select('partial oit.{id, title, description} AS oitInfo')
            ->addSelect(sprintf('(%s) as votePriority', $subQueryVoted))
            ->from(OptionInTournament::class, 'oit')
            ->andWhere('oit.idTournament = :idTournament')
            ->setParameter('idTournament', $tournament->getId())
            ->setParameter('user', $user->getId())
            ->andWhere('oit.deletedAt is NULL')
            ->getQuery();
    }

    /**
     * @param Tournament    $tournament
     * @param UserInterface $user
     *
     * @return Query
     */
    public function getResultForVoter(Tournament $tournament, UserInterface $user): Query
    {
        return $this->_em->createQueryBuilder()
            ->addSelect('v.priority')
            ->addSelect('oit.title')
            ->addSelect('oit.description')
            ->addSelect('t.votesQuantity')
            ->from(Vote::class, 'v')
            ->leftJoin('v.idOptionInTournament', 'oit',)
            ->leftJoin('oit.idTournament', 't')
            ->andWhere('v.idUser = :user')
            ->setParameter('user', $user->getId())
            ->andWhere('oit.idTournament = :idTournament')
            ->setParameter('idTournament', $tournament->getId())
            ->andWhere('v.isSelectedByPromoter = true')
            ->orderBy('v.priority', 'DESC')
            ->setMaxResults(1)
            ->getQuery();
    }

    /**
     * @param Tournament $tournament
     *
     * @return Query
     */
    public function getResultForModder(Tournament $tournament): Query
    {
        return $this->_em->createQueryBuilder()
            ->addSelect('v.id')
            ->addSelect('MAX(v.priority) maxPriority')
            ->addSelect('u.firstName userName')
            ->addSelect('u.lastName userLastName')
            ->addSelect('u.email')
            ->addSelect('t.name tournamentName')
            ->addSelect('t.description tournamentDescription')
            ->addSelect('oit.id optionInTournamentId')
            ->addSelect('oit.title optionInTournamentTitle')
            ->addSelect('oit.description optionInTournamentDescription')
            ->from(Vote::class, 'v')
            ->leftJoin('v.idOptionInTournament', 'oit')
            ->leftJoin('v.idUser', 'u')
            ->leftJoin('oit.idTournament', 't')
            ->andWhere('oit.idTournament = :idTournament')
            ->setParameter('idTournament', $tournament->getId())
            ->andWhere('v.isSelectedByPromoter = true')
            ->groupBy('u.id')
            ->orderBy('t.id')
            ->getQuery();
    }

    /**
     * @return Query
     */
    public function findAllTournamentAdmin(): Query
    {
        return $this
            ->getBasicQuery()
            ->select('t')
            ->orderBy('t.createAt', 'DESC')
            ->getQuery();
    }
}

