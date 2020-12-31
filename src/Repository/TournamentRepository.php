<?php

namespace App\Repository;

use App\Entity\OptionInTournament;
use App\Entity\Tournament;
use App\Entity\TournamentUser;
use App\Entity\User;
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
    function findAllMyTournament(?UserInterface $user)
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
            ->andWhere('t.deletedAt is NULL')
            ->setParameter('idUser', $user->getId())
            ->getQuery();

    }

    public function findAllOptionsInTournament(Tournament $tournament)
    {
        return $this->optionInTournamentRepository->getBasicQuery()
            ->andWhere('oit.idTournament = :idTournament')
            ->setParameter('idTournament', $tournament->getId())
            ->getQuery();
    }
}

