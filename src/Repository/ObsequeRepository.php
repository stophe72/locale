<?php

namespace App\Repository;

use App\Entity\ObsequeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ObsequeEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObsequeEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObsequeEntity[]    findAll()
 * @method ObsequeEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObsequeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObsequeEntity::class);
    }
}
