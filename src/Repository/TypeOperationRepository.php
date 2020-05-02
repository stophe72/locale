<?php

namespace App\Repository;

use App\Entity\TypeOperationEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeOperationEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOperationEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOperationEntity[]    findAll()
 * @method TypeOperationEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOperationEntity::class);
    }

    public function getQueryBuilder(UserEntity $user)
    {
        return $this->createQueryBuilder('ope')
            ->innerJoin('ope.user', 'user')
            ->innerJoin('ope.familleTypeOperation', 'fto')
            ->where('user = :userId')
            ->setParameter('userId', $user->getId());
    }
}
