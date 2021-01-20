<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getBasicQuery(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('u');
    }

    /**
     * @return Query
     */
    public function findAllQuery(): Query
    {
        return $this->getBasicQuery()->getQuery();
    }

    /**
     * @param int         $page
     * @param int         $pageLimit
     * @param string|null $query
     *
     * @return array
     */
    public function filterByQuery(int $page, int $pageLimit, string $query = null): array
    {
        $queryBuilder = $this->getBasicQuery()
            ->select('partial u.{id, firstName, lastName, email}')
            ->setMaxResults($pageLimit)
            ->setFirstResult(($page - 1) * $pageLimit);

        $queryResult = $queryBuilder
            ->orWhere($queryBuilder->expr()->like('u.email', ':email'))
            ->setParameter('email', '%' . $query . '%')
            ->orWhere($queryBuilder->expr()->like('u.firstName', ':firstName'))
            ->setParameter('firstName', '%' . $query . '%')
            ->orWhere($queryBuilder->expr()->like('u.lastName', ':lastName'))
            ->setParameter('lastName', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($queryResult as $user) {
            /** @var $user User */

            $result[] = [
                'id' => $user->getId(),
                'text' => (string)$user,
            ];
        }

        return $result;
    }

    /**
     * @param string $question
     *
     * @return Query
     */
    public function findUserByQuestion(string $question): Query
    {
        $likeQuestion = '%' . $question . '%';

        return $this->getBasicQuery()
            ->select('u')
            ->orWhere($this->getBasicQuery()->expr()->like('u.firstName', ':firstName'))
            ->orWhere($this->getBasicQuery()->expr()->like('u.lastName', ':lastName'))
            ->orWhere($this->getBasicQuery()->expr()->like('u.email', ':email'))
            ->setParameters([
                'firstName' => $likeQuestion,
                'lastName' => $likeQuestion,
                'email' => $likeQuestion,
            ])
            ->getQuery();
    }
}
