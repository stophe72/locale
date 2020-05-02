<?php

namespace App\Repository;

use App\Entity\FamilleTypeOperationEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}
