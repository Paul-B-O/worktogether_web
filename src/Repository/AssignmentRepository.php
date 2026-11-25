<?php

namespace App\Repository;

use App\Entity\Assignment;
use App\Entity\Customer;
use Doctrine\DBAL\Types\Types;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Assignment>
 */
class AssignmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assignment::class);
    }

    /**
     * Affectations du client actives à la date donnée, avec unité et rack chargés.
     *
     * @return list<Assignment>
     */
    public function findActiveByCustomer(Customer $customer, \DateTimeImmutable $today): array
    {
        return $this->createQueryBuilder('a')
            ->addSelect('u', 'r', 'o')
            ->innerJoin('a.unit', 'u')
            ->innerJoin('u.rack', 'r')
            ->innerJoin('a.customerOrder', 'o')
            ->andWhere('o.customer = :customer')
            ->andWhere('a.startDate <= :today')
            ->andWhere('a.endDate >= :today')
            ->setParameter('customer', $customer)
            ->setParameter('today', $today, Types::DATE_IMMUTABLE)
            ->orderBy('r.number', 'ASC')
            ->addOrderBy('u.number', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Assignment[] Returns an array of Assignment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Assignment
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
