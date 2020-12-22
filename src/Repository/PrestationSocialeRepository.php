<?php

namespace App\Repository;

use App\Entity\PrestationSocialeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

/**
 * @method PrestationSociale|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrestationSociale|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrestationSociale[]    findAll()
 * @method PrestationSociale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestationSocialeRepository extends ServiceEntityRepository
{
    public function __construct(PersistenceManagerRegistry $registry)
    {
        parent::__construct($registry, PrestationSocialeEntity::class);
    }

    // /**
    //  * @return PrestationSociale[] Returns an array of PrestationSociale objects
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
    public function findOneBySomeField($value): ?PrestationSociale
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
