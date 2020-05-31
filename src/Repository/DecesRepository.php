<?php

namespace App\Repository;

use App\Entity\DecesEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DecesEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method DecesEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method DecesEntity[]    findAll()
 * @method DecesEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DecesEntity::class);
    }
}
