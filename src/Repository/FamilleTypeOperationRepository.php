<?php

namespace App\Repository;

use App\Entity\FamilleTypeOperationEntity;
use App\Entity\TypeOperationEntity;
use App\Entity\MandataireEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FamilleOperationEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilleOperationEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilleOperationEntity[]    findAll()
 * @method FamilleOperationEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilleTypeOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilleTypeOperationEntity::class);
    }

    public function countById(MandataireEntity $mandataire, int $id)
    {
        $qb = $this->createQueryBuilder('fto');
        $qb->select('COUNT(fto.id)')
            ->innerJoin(TypeOperationEntity::class, 'to', Join::WITH, 'fto = to.familleTypeOperation')
            ->where('fto = :familleTypeOperationId')
            ->andWhere('fto.groupe = :groupeId')
            ->setParameter('familleTypeOperationId', $id)
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
