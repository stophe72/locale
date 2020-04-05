<?php

namespace App\Repository;

use App\Entity\VisiteEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VisiteEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisiteEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisiteEntity[]    findAll()
 * @method VisiteEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisiteEntity::class);
    }

    public function getAllOrderByNomPrenom()
    {
        $qb = $this->createQueryBuilder('v')
            ->innerJoin('v.majeur', 'm')
            ->orderBy('m.nom', 'ASC')
            ->addOrderBy('m.prenom', 'ASC');

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return VisiteEntity[] Returns an array of VisiteEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VisiteEntity
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
