<?php

namespace App\Repository;

use App\Entity\TribunalEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TribunalEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TribunalEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TribunalEntity[]    findAll()
 * @method TribunalEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TribunalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TribunalEntity::class);
    }

    // /**
    //  * @return TribunalEntity[] Returns an array of TribunalEntity objects
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
    public function findOneBySomeField($value): ?TribunalEntity
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
