<?php

namespace App\Repository;

use App\DTO\BookSearchCriteria;
use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findAllOrderedByDate(int $limit = 20, int $page = 1)
    {
        return $this
            ->createQueryBuilder('book') // QueryBuilder
            ->orderBy('book.createdAt', 'ASC') // QueryBuilder
            ->setMaxResults($limit) // QueryBuilder
            ->setFirstResult(($page - 1) * $limit) // QueryBuilder
            ->getQuery() // Query
            ->getResult(); // Book[]
    }

    public function findAllBySearchCriterias(BookSearchCriteria $criterias)
    {
        $queryBuilder = $this // BookRepository
            ->createQueryBuilder('book') // QueryBuilder
            ->setMaxResults($criterias->limit) // QueryBuilder
            ->setFirstResult(($criterias->page - 1) * $criterias->limit)
            ->orderBy('book.' . $criterias->orderBy, $criterias->direction); // QueryBuilder

        if ($criterias->name) {
            $queryBuilder = $queryBuilder
                ->andWhere('book.name LIKE :name')
                ->setParameter('name', '%' . $criterias->name . '%');
        }

        if ($criterias->startingPrice !== null) {
            $queryBuilder = $queryBuilder
                ->andWhere('book.price >= :startingPrice')
                ->setParameter('startingPrice', $criterias->startingPrice);
        }

        if ($criterias->endingPrice !== null) {
            $queryBuilder = $queryBuilder
                ->andWhere('book.price <= :endingPrice')
                ->setParameter('endingPrice', $criterias->endingPrice);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    //public function findFiveOrderByName(string $name)
    //{
    //    // Création d'un query builder dont le rôle
    //    // est de rechercher des entités en utilisant
    //    // un syntax proche de SQL.
    //    $queryBuilder = $this
    //        ->createQueryBuilder('book')
    //        ->andWhere('book.name LIKE :name')
    //        ->setParameter('name', '%' . $name . '%')
    //        ->orderBy('book.name', 'ASC')
    //        ->setMaxResults(5);

    //    // Nous créons la requête SQL qui correspond
    //    // à notre query builder plus haut.
    //    $query = $queryBuilder->getQuery();

    //    // Nous retournons les livres (book) qui match
    //    // notre requête
    //    return $query->getResult();
    //}


    // /**
    //  * @return Book[] Returns an array of Book objects
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
    public function findOneBySomeField($value): ?Book
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
