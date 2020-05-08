<?php

namespace App\Repository;

use App\Entity\DonneeBancaireEntity;
use App\Entity\TypeCompteEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method TypeCompteEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeCompteEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeCompteEntity[]    findAll()
 * @method TypeCompteEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeCompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeCompteEntity::class);
    }

    public function countById(UserEntity $user, int $id)
    {
        $qb  = $this->createQueryBuilder('tc');
        $qb->select('COUNT(tc.id)')
            ->innerJoin(DonneeBancaireEntity::class, 'db', Join::WITH, 'db.typeCompte = tc')
            ->innerJoin('db.majeur', 'm')
            ->innerJoin('m.user', 'u')
            ->where('tc = :typeCompteId')
            ->andWhere('u = :userId')
            ->setParameter('typeCompteId', $id)
            ->setParameter('userId', $user->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
