<?php

namespace App\Repository;

use App\Entity\ResponseYn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponseYn|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseYn|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseYn[]    findAll()
 * @method ResponseYn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseYnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseYn::class);
    }

    // /**
    //  * @return ResponseYn[] Returns an array of ResponseYn objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResponseYn
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
