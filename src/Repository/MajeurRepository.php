<?php

namespace App\Repository;

use App\Entity\MajeurEntity;
use App\Entity\MandataireEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method MajeurEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MajeurEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MajeurEntity[]    findAll()
 * @method MajeurEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MajeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MajeurEntity::class);
    }

    public function getAllOrderByNomPrenom(UserEntity $user)
    {
        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.user', 'u')
            ->where('u = :userId')
            ->setParameter('userId', $user->getId())
            ->orderBy('m.nom', 'ASC')
            ->addOrderBy('m.prenom', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findByName(?string $name, UserEntity $user, $maxResult = 12)
    {
        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.user', 'user')
            ->where('user = :userId')
            ->andWhere('LOWER(m.nom) LIKE LOWER(:nom)')
            ->setParameter('userId', $user->getId())
            ->setParameter('nom', '%' . $name . '%')
            ->addOrderBy('m.nom', 'ASC')
            ->addOrderBy('m.prenom', 'ASC')
            ->setMaxResults($maxResult);

        return $qb->getQuery()->getResult();
    }

    public function findForGroupe(UserEntity $user)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->innerJoin('m.groupe', 'g')
            ->innerJoin(MandataireEntity::class, 'ma', Join::WITH, 'ma.groupe = g')
            ->innerJoin('ma.user', 'u')
            ->where('u = :userId')
            ->setParameter('userId', $user->getId())
            ->orderBy('m.nom', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
