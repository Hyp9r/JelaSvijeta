<?php

namespace App\Repository;

use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meal::class);
    }

    // /**
    //  * @return Meal[] Returns an array of Meal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Meal
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function filter(array $filters)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->select('m', 't')->leftJoin('m.tags', 't');

        //check category
        if ($filters['category'] !== null) {
            if ($filters['category'] === "NULL") {
                $qb->andWhere('m.category IS NULL');
            } elseif ($filters['category'] === "!NULL") {
                $qb->andWhere('m.category IS NOT NULL');
            } else {
                $qb->andWhere('m.category = :category')
                    ->setParameter('category', $filters['category']);
            }
        }

        //check tags
        if ($filters['tags'] !== null) {
            //split $filters['tags'] into array.
            $tags = explode(',', $filters['tags']);
            for ($i = 0; $i < count($tags); $i++) {
                $qb->innerJoin('m.tags', 't' . $i, Join::WITH, 't' . $i . '= :tag' . $i);
                $qb->setParameter('tag' . $i, $tags[$i]);
            }
        }
        return $qb->getQuery()->getResult();
    }
}
