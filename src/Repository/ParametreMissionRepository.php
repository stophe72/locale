<?php

namespace App\Repository;

use App\Entity\ParametreMission;
use App\Entity\ParametreMissionEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ParametreMission|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametreMission|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametreMission[]    findAll()
 * @method ParametreMission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametreMissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametreMissionEntity::class);
    }
}
