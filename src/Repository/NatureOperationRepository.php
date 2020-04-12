<?php

namespace App\Repository;

use App\Entity\NatureOperationEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NatureOperationEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method NatureOperationEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method NatureOperationEntity[]    findAll()
 * @method NatureOperationEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NatureOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NatureOperationEntity::class);
    }
}
