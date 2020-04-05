<?php

namespace App\Repository;

use App\Entity\MajeurEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MajeurEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MajeurEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MajeurEntity[]    findAll()
 * @method MajeurEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MajeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MajeurEntity::class);
    }

    public function getAllOrderByNomPrenom()
    {
        $qb = $this->createQueryBuilder('m')
            ->orderBy('m.nom', 'ASC')
            ->addOrderBy('m.prenom', 'ASC');

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return MajeurEntity[] Returns an array of MajeurEntity objects
    //  */
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
    public function findOneBySomeField($value): ?MajeurEntity
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
