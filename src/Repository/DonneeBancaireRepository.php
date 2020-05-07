<?php

namespace App\Repository;

use App\Entity\DonneeBancaireEntity;
use App\Entity\MajeurEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DonneeBancaireEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method DonneeBancaireEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method DonneeBancaireEntity[]    findAll()
 * @method DonneeBancaireEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonneeBancaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonneeBancaireEntity::class);
    }

    public function findByMajeur(UserEntity $user, MajeurEntity $majeur)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->innerJoin('b.majeur', 'm')
            ->innerJoin('m.user', 'u')
            ->where('m = :majeurId')
            ->andWhere('u = :userId')
            ->setParameter('majeurId', $majeur->getId())
            ->setParameter('userId', $user->getId());

        return $qb->getQuery()->getResult();
    }
}
