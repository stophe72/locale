<?php

namespace App\Repository;

use App\Entity\TypeCompteEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeCompteEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeCompteEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeCompteEntity[]    findAll()
 * @method TypeCompteEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeCompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeCompteEntity::class);
    }

    // /**
    //  * @return TypeCompteEntity[] Returns an array of TypeCompteEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeCompteEntity
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
