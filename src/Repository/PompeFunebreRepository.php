<?php

namespace App\Repository;

use App\Entity\DecesEntity;
use App\Entity\MandataireEntity;
use App\Entity\PompeFunebreEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PompeFunebreEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PompeFunebreEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PompeFunebreEntity[]    findAll()
 * @method PompeFunebreEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PompeFunebreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PompeFunebreEntity::class);
    }

    public function countById(MandataireEntity $mandataire, int $id)
    {
        $qb = $this->createQueryBuilder('pf')
            ->select('COUNT(pf.id)')
            ->innerJoin(DecesEntity::class, 'd', Join::WITH, 'd.pompeFunebre = pf')
            ->where('pf.id = :pompeFunebreId')
            ->andWhere('pf.groupe = :groupeId')
            ->setParameter('pompeFunebreId', $id)
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
