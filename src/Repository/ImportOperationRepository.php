<?php

namespace App\Repository;

use App\Entity\ImportOperationEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImportOperationEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImportOperationEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImportOperationEntity[]    findAll()
 * @method ImportOperationEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImportOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImportOperationEntity::class);
    }

    public function findByUser(UserEntity $user)
    {
        $qb = $this->createQueryBuilder('io');
        $qb->innerJoin('io.majeur', 'm')
            ->andWhere('m.user = :userId')
            ->setParameter('userId', $user->getId())
            ->orderBy('m.nom', 'ASC')
            ->addOrderBy('m.prenom', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
