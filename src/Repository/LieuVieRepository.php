<?php

namespace App\Repository;

use App\Entity\LieuVie;
use App\Entity\LieuVieEntity;
use App\Entity\MajeurEntity;
use App\Entity\ParametreMissionEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method LieuVie|null find($id, $lockMode = null, $lockVersion = null)
 * @method LieuVie|null findOneBy(array $criteria, array $orderBy = null)
 * @method LieuVie[]    findAll()
 * @method LieuVie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LieuVieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LieuVieEntity::class);
    }

    public function countById(UserEntity $user, int $lieuVieId)
    {
        $qb = $this->createQueryBuilder('lv');
        $qb->select('COUNT(lv.id)')
            ->innerJoin(ParametreMissionEntity::class, 'pm', Join::WITH, 'pm.lieuVie = lv')
            ->innerJoin(MajeurEntity::class, 'm', Join::WITH, 'm.parametreMission = pm')
            ->innerJoin('m.user', 'u')
            ->where('lv = :lieuVieId')
            ->andWhere('u = :userId')
            ->setParameter('lieuVieId', $lieuVieId)
            ->setParameter('userId', $user->getId());

        return $qb->getQuery()->getSingleScalarResult();
    }
}
