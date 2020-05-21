<?php

namespace App\Repository;

use App\Entity\MandataireEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MandataireEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MandataireEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MandataireEntity[]    findAll()
 * @method MandataireEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MandataireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MandataireEntity::class);
    }

    public function getGroupe(UserEntity $user)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->innerJoin('m.user', 'u', Join::WITH, 'u = :userId')
            ->setParameter('userId', $user->getId());

        return $qb->getQuery()->getSingleResult();
    }
}
