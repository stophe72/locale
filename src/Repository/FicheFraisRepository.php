<?php

namespace App\Repository;

use App\Entity\FicheFraisEntity;
use App\Entity\NoteDeFraisEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FicheFrais|null find($id, $lockMode = null, $lockVersion = null)
 * @method FicheFrais|null findOneBy(array $criteria, array $orderBy = null)
 * @method FicheFrais[]    findAll()
 * @method FicheFrais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheFraisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FicheFraisEntity::class);
    }

    public function getAllByFiche(UserEntity $user)
    {
        $qb = $this->createQueryBuilder('ff')
            ->leftJoin(NoteDeFraisEntity::class, 'ndf', Join::WITH, 'ndf.ficheFrais = ff.id')
            ->innerJoin('ff.user', 'user')
            ->where('user = :userId')
            ->setParameter('userId', $user->getId())
            ->orderBy('ff.id', 'DESC')
            ->addOrderBy('ndf.date', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
