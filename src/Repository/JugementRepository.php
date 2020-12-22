<?php

namespace App\Repository;

use App\Entity\JugementEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

/**
 * @method JugementEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method JugementEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method JugementEntity[]    findAll()
 * @method JugementEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JugementRepository extends ServiceEntityRepository
{
    public function __construct(PersistenceManagerRegistry $registry)
    {
        parent::__construct($registry, JugementEntity::class);
    }
}
