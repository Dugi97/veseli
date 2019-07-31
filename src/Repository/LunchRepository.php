<?php

namespace App\Repository;

use App\Entity\Lunch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Lunch|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lunch|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lunch[]    findAll()
 * @method Lunch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LunchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lunch::class);
    }

    // /**
    //  * @return Lunch[] Returns an array of Lunch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lunch
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
