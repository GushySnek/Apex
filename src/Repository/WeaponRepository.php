<?php

namespace App\Repository;

use App\Entity\Weapon;
use App\Search\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Weapon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weapon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weapon[]    findAll()
 * @method Weapon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weapon::class);
    }

    public function findSearchResults(Search $search): Array
    {
        $qb = $this->createQueryBuilder('w');

        if (!empty($search->getKeyword())) {
            $qb->andWhere('w.name LIKE :keyword')
                ->setParameter('keyword', "%{$search->getKeyword()}%");
        }

        if (count($search->getTags()) > 0) {
            $qb->leftJoin('w.tags', 't')
                ->andWhere('t in (:tags)')
                ->setParameter('tags', $search->getTags());
        }

        return $qb->getQuery()->getResult();
    }

    public function findByTag(string $name): array
    {
        $qb = $this->createQueryBuilder('w');

        $qb->leftJoin('w.type', 'wr')
            ->where('wr.name = :name')
            ->setParameter('name', $name)
            ->leftJoin('w.tag', 'wt')
            ->orWhere('wt.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Weapon[] Returns an array of Weapon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Weapon
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
