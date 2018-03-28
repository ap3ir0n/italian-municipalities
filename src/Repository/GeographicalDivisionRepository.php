<?php

namespace App\Repository;

use App\Entity\GeographicalDivision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GeographicalDivision|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeographicalDivision|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeographicalDivision[]    findAll()
 * @method GeographicalDivision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeographicalDivisionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GeographicalDivision::class);
    }

//    /**
//     * @return GeographicalDivision[] Returns an array of GeographicalDivision objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeographicalDivision
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
