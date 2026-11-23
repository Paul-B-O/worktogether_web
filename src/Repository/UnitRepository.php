<?php

namespace App\Repository;

use App\Entity\Unit;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Unit>
 */
class UnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unit::class);
    }

    /**
     * @return Unit[] Les unités louées par l'utilisateur, avec leur baie déjà chargée
     */
    public function findByUser(UserInterface $user): array
    {
        return $this->createQueryBuilder('u')
            ->addSelect('r')
            ->innerJoin('u.rack', 'r')
            ->innerJoin('u.assignments', 'a')
            ->innerJoin('a.customerOrder', 'o')
            ->andWhere('o.customer = :user')
            ->setParameter('user', $user)
            ->orderBy('r.number', 'ASC')
            ->addOrderBy('u.number', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Unit
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
