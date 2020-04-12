<?php

namespace App\Repository;

use App\Entity\CompteGestionEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompteGestionEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteGestionEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteGestionEntity[]    findAll()
 * @method CompteGestionEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteGestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteGestionEntity::class);
    }
}
