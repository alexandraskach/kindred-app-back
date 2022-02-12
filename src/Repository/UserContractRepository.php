<?php

namespace App\Repository;

use App\Entity\UserContract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserContract|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserContract|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserContract[]    findAll()
 * @method UserContract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserContractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserContract::class);
    }

    // /**
    //  * @return UserContract[] Returns an array of UserContract objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserContract
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
