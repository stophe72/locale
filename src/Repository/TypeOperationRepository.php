<?php

namespace App\Repository;

use App\Entity\CompteGestionEntity;
use App\Entity\ImportOperationEntity;
use App\Entity\MandataireEntity;
use App\Entity\TypeOperationEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeOperationEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOperationEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOperationEntity[]    findAll()
 * @method TypeOperationEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOperationEntity::class);
    }

    public function getQueryBuilder(MandataireEntity $mandataire)
    {
        return $this->createQueryBuilder('ope')
            ->innerJoin('ope.familleTypeOperation', 'fto')
            ->where('ope.groupe = :groupeId')
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());
    }

    public function countByCompteGestion(MandataireEntity $mandataire, int $id)
    {
        $qb = $this->createQueryBuilder('to');
        $qb->select('COUNT(to.id)')
            ->innerJoin(CompteGestionEntity::class, 'cg', Join::WITH, 'cg.typeOperation = to')
            ->where('to = :typeOperationId')
            ->andWhere('to.groupe = :groupeId')
            ->setParameter('typeOperationId', $id)
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }

    public function countByImportOperation(MandataireEntity $mandataire, int $id)
    {
        $qb = $this->createQueryBuilder('to');
        $qb->select('COUNT(to.id)')
            ->innerJoin(ImportOperationEntity::class, 'io', Join::WITH, 'io.typeOperation = to')
            ->where('to = :typeOperationId')
            ->andWhere('to.groupe = :groupeId')
            ->setParameter('typeOperationId', $id)
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
