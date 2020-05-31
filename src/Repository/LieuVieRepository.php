<?php

namespace App\Repository;

use App\Entity\LieuVie;
use App\Entity\LieuVieEntity;
use App\Entity\ParametreMissionEntity;
use App\Entity\MandataireEntity;
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

    public function countById(MandataireEntity $mandataire, int $lieuVieId)
    {
        $qb = $this->createQueryBuilder('lv');
        $qb->select('COUNT(lv.id)')
            ->innerJoin(ParametreMissionEntity::class, 'pm', Join::WITH, 'pm.lieuVie = lv')
            ->where('lv = :lieuVieId')
            ->andWhere('lv.groupe = :groupeId')
            ->setParameter('lieuVieId', $lieuVieId)
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return $qb->getQuery()->getSingleScalarResult();
    }
}
