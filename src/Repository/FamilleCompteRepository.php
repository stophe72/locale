<?php

namespace App\Repository;

use App\Entity\DonneeBancaireEntity;
use App\Entity\FamilleCompteEntity;
use App\Entity\TypeCompteEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

    public function countById(UserEntity $user, int $id)
    {
        $qb = $this->createQueryBuilder('fc');
        $qb->select('COUNT(fc.id)')
            ->innerJoin(TypeCompteEntity::class, 'tc', Join::WITH, 'tc.familleCompte = fc')
            ->innerJoin(DonneeBancaireEntity::class, 'db', Join::WITH, 'db.typeCompte = tc')
            ->innerJoin('db.majeur', 'm')
            ->innerJoin('m.user', 'u')
            ->where('fc = :familleCompteId')
            ->andWhere('u = :userId')
            ->setParameter('userId', $user->getId())
            ->setParameter('familleCompteId', $id);

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
