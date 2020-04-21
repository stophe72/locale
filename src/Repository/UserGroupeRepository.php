<?php

namespace App\Repository;

use App\Entity\UserGroupeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserGroupeEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroupeEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroupeEntity[]    findAll()
 * @method UserGroupeEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGroupeEntity::class);
    }
}
