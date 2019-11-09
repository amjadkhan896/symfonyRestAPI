<?php

namespace App\Repository;

use App\Entity\Pgroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Pgroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pgroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pgroup[]    findAll()
 * @method Pgroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PgroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pgroup::class);
    }

    // /**
    //  * @return Pgroup[] Returns an array of Pgroup objects
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
    public function findOneBySomeField($value): ?Pgroup
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Add a simple save method so you don't need to use persist and flush in your service classes
     */
    public function save(Pgroup $pGroup)
    {
        // _em is EntityManager which is DI by the base class
        $this->_em->persist($pGroup);
        $this->_em->flush();
    }


    /**
     * deleting an item
     */
    public function remove(Pgroup $pGroup)
    {
        // _em is EntityManager which is DI by the base class
        $this->_em->remove($pGroup);
        $this->_em->flush();
    }
}
