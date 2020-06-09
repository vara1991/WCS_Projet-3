<?php

namespace App\Repository;

use App\Entity\EvalScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvalScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvalScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvalScore[]    findAll()
 * @method EvalScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvalScore::class);
    }

    // /**
    //  * @return EvalScore[] Returns an array of EvalScore objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EvalScore
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
