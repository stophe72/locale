<?php

namespace App\Repository;

use App\Entity\MesureEntity;
use App\Entity\ParametreMissionEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method MesureEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MesureEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MesureEntity[]    findAll()
 * @method MesureEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MesureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MesureEntity::class);
    }

    public function countById(UserEntity $user, int $id)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->select('COUNT(m.id)')
            ->innerJoin(ParametreMissionEntity::class, 'pm', Join::WITH, 'pm.mesure = m')
            ->innerJoin('m.user', 'u')
            ->where('m = :mesureId')
            ->andWhere('u = :userId')
            ->setParameter('mesureId', $id)
            ->setParameter('userId', $user->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
