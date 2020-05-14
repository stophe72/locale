<?php

namespace App\Repository;

use App\Entity\GroupeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupeEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeEntity[]    findAll()
 * @method GroupeEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeEntity::class);
    }
}
