<?php

namespace App\Repository;

use App\Entity\Prdouct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Prdouct|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prdouct|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prdouct[]    findAll()
 * @method Prdouct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrdouctRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prdouct::class);
    }

    // /**
    //  * @return Prdouct[] Returns an array of Prdouct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prdouct
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
