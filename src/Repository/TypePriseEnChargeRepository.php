<?php

namespace App\Repository;

use App\Entity\GroupeEntity;
use App\Entity\MandataireEntity;
use App\Entity\TypePriseEnChargeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypePriseEnChargeEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePriseEnChargeEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePriseEnChargeEntity[]    findAll()
 * @method TypePriseEnChargeEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePriseEnChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePriseEnChargeEntity::class);
    }

    public function countById(MandataireEntity $mandataire, int $id)
    {
    }
}
