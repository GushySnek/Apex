<?php

namespace App\Repository;

use App\Entity\Hero;
use App\Search\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hero|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hero|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hero[]    findAll()
 * @method Hero[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hero::class);
    }

    public function findSearchResults(Search $search): Array
    {
        $qb = $this->createQueryBuilder('c');

        if (!empty($search->getKeyword())) {
            $qb->andWhere('c.name LIKE :keyword')
                ->setParameter('keyword', "%{$search->getKeyword()}%");
        }

        if (count($search->getTags()) > 0) {
            $qb->leftJoin('c.tags', 't')
                ->andWhere('t in (:tags)')
                ->setParameter('tags', $search->getTags());
        }

        return $qb->getQuery()->getResult();
    }

    public function findByTag(string $name): array
    {
        $qb = $this->createQueryBuilder('h');

        $qb->leftJoin('h.role', 'hr')
           ->where('hr.name = :name')
           ->setParameter('name', $name)
           ->leftJoin('h.tag', 'ht')
           ->orWhere('ht.name = :name')
           ->setParameter('name', $name);

        return $qb->getQuery()->getResult();
    }


    // /**
    //  * @return Character[] Returns an array of Character objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Character
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
