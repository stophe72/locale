<?php

namespace App\Repository;

use App\Entity\ParametreMissionEntity;
use App\Entity\ProtectionEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method ProtectionEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProtectionEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProtectionEntity[]    findAll()
 * @method ProtectionEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProtectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProtectionEntity::class);
    }

    public function countById(UserEntity $user, int $id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('COUNT(p.id)')
            ->innerJoin(ParametreMissionEntity::class, 'pm', Join::WITH, 'pm.protection = p')
            ->innerJoin('p.user', 'u')
            ->where('p = :protectionId')
            ->andWhere('u = :userId')
            ->setParameter('protectionId', $id)
            ->setParameter('userId', $user->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
