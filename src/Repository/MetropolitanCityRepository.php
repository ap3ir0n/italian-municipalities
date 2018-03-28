<?php

namespace App\Repository;

use App\Entity\MetropolitanCity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MetropolitanCity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MetropolitanCity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MetropolitanCity[]    findAll()
 * @method MetropolitanCity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetropolitanCityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MetropolitanCity::class);
    }

//    /**
//     * @return MetropolitanCity[] Returns an array of MetropolitanCity objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MetropolitanCity
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
