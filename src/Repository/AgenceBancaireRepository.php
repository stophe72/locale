<?php

namespace App\Repository;

use App\Entity\AgenceBancaireEntity;
use App\Entity\DonneeBancaireEntity;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method AgenceBancaireEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgenceBancaireEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgenceBancaireEntity[]    findAll()
 * @method AgenceBancaireEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenceBancaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgenceBancaireEntity::class);
    }

    public function countByDonneeBancaire(UserEntity $user, int $agenceBancaireId)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('COUNT(a.id)')
            ->innerJoin(DonneeBancaireEntity::class, 'b', Join::WITH, 'b.agenceBancaire = a')
            ->innerJoin('b.majeur', 'm')
            ->innerJoin('m.user', 'u')
            ->where('a = :agenceBancaireId')
            ->andWhere('u = :userId')
            ->setParameter('agenceBancaireId', $agenceBancaireId)
            ->setParameter('userId', $user->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
