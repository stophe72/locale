<?php

namespace App\Repository;

use App\Entity\SuiviEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SuiviEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuiviEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuiviEntity[]    findAll()
 * @method SuiviEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiviRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuiviEntity::class);
    }
}
