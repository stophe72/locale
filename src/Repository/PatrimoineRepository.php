<?php

namespace App\Repository;

use App\Entity\PatrimoineEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PatrimoineEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatrimoineEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatrimoineEntity[]    findAll()
 * @method PatrimoineEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatrimoineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatrimoineEntity::class);
    }
}
