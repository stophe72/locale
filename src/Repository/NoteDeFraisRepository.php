<?php

namespace App\Repository;

use App\Entity\NoteDeFraisEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NoteDeFraisEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteDeFraisEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteDeFraisEntity[]    findAll()
 * @method NoteDeFraisEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteDeFraisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoteDeFraisEntity::class);
    }
}
