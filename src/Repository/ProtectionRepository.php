<?php

namespace App\Repository;

use App\Entity\ParametreMissionEntity;
use App\Entity\ProtectionEntity;
use App\Entity\MandataireEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

/**
 * @method ProtectionEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProtectionEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProtectionEntity[]    findAll()
 * @method ProtectionEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProtectionRepository extends ServiceEntityRepository
{
    public function __construct(PersistenceManagerRegistry $registry)
    {
        parent::__construct($registry, ProtectionEntity::class);
    }

    public function countById(MandataireEntity $mandataire, int $id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('COUNT(p.id)')
            ->innerJoin(ParametreMissionEntity::class, 'pm', Join::WITH, 'pm.protection = p')
            ->where('p = :protectionId')
            ->andWhere('p.groupe = :groupeId')
            ->setParameter('protectionId', $id)
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
