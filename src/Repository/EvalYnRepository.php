<?php

namespace App\Repository;

use App\Entity\EvalYn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvalYn|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvalYn|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvalYn[]    findAll()
 * @method EvalYn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalYnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvalYn::class);
    }

    // /**
    //  * @return EvalYn[] Returns an array of EvalYn objects
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
    public function findOneBySomeField($value): ?EvalYn
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
