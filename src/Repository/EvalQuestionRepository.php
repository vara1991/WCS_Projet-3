<?php

namespace App\Repository;

use App\Entity\EvalQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvalQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvalQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvalQuestion[]    findAll()
 * @method EvalQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvalQuestion::class);
    }

    // /**
    //  * @return EvalQuestion[] Returns an array of EvalQuestion objects
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
    public function findOneBySomeField($value): ?EvalQuestion
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
