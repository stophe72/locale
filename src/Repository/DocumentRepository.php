<?php

namespace App\Repository;

use App\Entity\DocumentEntity;
use App\Entity\MandataireEntity;
use App\Models\DocumentFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocumentEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentEntity[]    findAll()
 * @method DocumentEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentEntity::class);
    }

    public function getFromFilter(MandataireEntity $mandataire, DocumentFilter $filter)
    {
        $qb = $this->createQueryBuilder('d');
        $qb->where('d.groupe = :groupeId')
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        if ($filter->getLibelle()) {
            $qb->andWhere('LOWER(d.libelle) LIKE LOWER(:libelle)')
                ->setParameter('libelle', '%' . $filter->getLibelle() . '%');
        }
        if ($filter->getObservations()) {
            $qb->andWhere('LOWER(d.observations) LIKE LOWER(:observations)')
                ->setParameter('observations', '%' . $filter->getObservations() . '%');
        }
        if ($filter->getMajeur()) {
            $qb->innerJoin('d.majeur', 'm')
                ->andWhere('m = :majeurId')
                ->setParameter('majeurId', $filter->getMajeur()->getId());
        }
        return $qb->getQuery()->getResult();
    }
}
