<?php

namespace App\Repository;

use App\Entity\News;
use App\Entity\Tag;
use App\Search\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function findSearchResults(Search $search): array
    {
        $qb = $this->createQueryBuilder('n');

        if (!empty($search->getKeyword())) {
            $qb->andWhere('n.title LIKE :keyword')
                ->setParameter('keyword', "%{$search->getKeyword()}%");
        }

        if (count($search->getNewsTags()) > 0) {
            $qb->leftJoin('n.tags', 'nt')
                ->andWhere('nt in (:newsTags)')
                ->setParameter('newsTags', $search->getNewsTags());
        }

        if (count($search->getWeaponsTags()) > 0) {
            $qb->leftJoin('n.tags', 'wt')
                ->andWhere('wt in (:weaponsTags)')
                ->setParameter('weaponsTags', $search->getWeaponsTags());
        }

        if (count($search->getHeroesTags()) > 0) {
            $qb->leftJoin('n.tags', 'ht')
                ->andWhere('ht in (:heroesTags)')
                ->setParameter('heroesTags', $search->getHeroesTags());
        }

        return $qb->getQuery()->getResult();
    }

    public function findWithLimit($limit): array
    {
        $qb = $this->createQueryBuilder('n');

        $qb->orderBy('n.date', 'DESC')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function findByTag(string $name): array
    {
        $qb = $this->createQueryBuilder('n');

        $qb->leftJoin('n.tags', 'nt')
            ->andWhere('nt.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return News[] Returns an array of News objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
