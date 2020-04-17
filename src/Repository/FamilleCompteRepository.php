<?php

namespace App\Repository;

use App\Entity\FamilleCompteEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FamilleCompteEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilleCompteEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilleCompteEntity[]    findAll()
 * @method FamilleCompteEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilleCompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilleCompteEntity::class);
    }
}
