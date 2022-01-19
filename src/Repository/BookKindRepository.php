<?php

namespace App\Repository;

use App\Entity\BookKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookKind[]    findAll()
 * @method BookKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookKind::class);
    }

    // /**
    //  * @return BookKind[] Returns an array of BookKind objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookKind
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
