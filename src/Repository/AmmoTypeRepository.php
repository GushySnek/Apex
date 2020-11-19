<?php

namespace App\Repository;

use App\Entity\AmmoType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AmmoType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmmoType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmmoType[]    findAll()
 * @method AmmoType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmmoTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmmoType::class);
    }

    // /**
    //  * @return AmmoType[] Returns an array of AmmoType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AmmoType
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
