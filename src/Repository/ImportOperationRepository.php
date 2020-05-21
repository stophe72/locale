<?php

namespace App\Repository;

use App\Entity\ImportOperationEntity;
use App\Entity\MandataireEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function findByGroupe(MandataireEntity $mandataire)
    {
        $qb = $this->createQueryBuilder('io');
        $qb->innerJoin('io.majeur', 'm')
            ->andWhere('m.groupe = :groupeId')
            ->setParameter('groupeId', $mandataire->getGroupe()->getId())
            ->orderBy('m.nom', 'ASC')
            ->addOrderBy('m.prenom', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
