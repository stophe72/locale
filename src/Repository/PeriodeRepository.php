<?php

namespace App\Repository;

use App\Entity\PeriodeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

/**
 * @method PeriodeEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PeriodeEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PeriodeEntity[]    findAll()
 * @method PeriodeEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeriodeRepository extends ServiceEntityRepository
{
    public function __construct(PersistenceManagerRegistry $registry)
    {
        parent::__construct($registry, PeriodeEntity::class);
    }

    // /**
    //  * @return PeriodeEntity[] Returns an array of PeriodeEntity objects
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
    public function findOneBySomeField($value): ?PeriodeEntity
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