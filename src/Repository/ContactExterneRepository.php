<?php

namespace App\Repository;

use App\Entity\ContactExterneEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactExterneEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactExterneEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactExterneEntity[]    findAll()
 * @method ContactExterneEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactExterneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactExterneEntity::class);
    }

    // /**
    //  * @return ContactExterneEntity[] Returns an array of ContactExterneEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContactExterneEntity
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
