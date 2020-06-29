<?php

namespace App\Repository;

use App\Entity\ResponseQcm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponseQcm|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseQcm|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseQcm[]    findAll()
 * @method ResponseQcm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseQcmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseQcm::class);
    }

    // /**
    //  * @return ResponseQcm[] Returns an array of ResponseQcm objects
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
    public function findOneBySomeField($value): ?ResponseQcm
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
