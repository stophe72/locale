<?php

namespace App\Repository;

use App\Entity\LieuVie;
use App\Entity\LieuVieEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LieuVie|null find($id, $lockMode = null, $lockVersion = null)
 * @method LieuVie|null findOneBy(array $criteria, array $orderBy = null)
 * @method LieuVie[]    findAll()
 * @method LieuVie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LieuVieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LieuVieEntity::class);
    }

    // /**
    //  * @return LieuVie[] Returns an array of LieuVie objects
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
    public function findOneBySomeField($value): ?LieuVie
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
