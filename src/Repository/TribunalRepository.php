<?php

namespace App\Repository;

use App\Entity\JugementEntity;
use App\Entity\MajeurEntity;
use App\Entity\TribunalEntity;
use App\Entity\MandataireEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method TribunalEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TribunalEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TribunalEntity[]    findAll()
 * @method TribunalEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TribunalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TribunalEntity::class);
    }

    public function countByJugement(MandataireEntity $mandataire, int $tribunalId)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('COUNT(t.id)')
            ->innerJoin(JugementEntity::class, 'j', Join::WITH, 'j.tribunal = t')
            ->where('t = :tribunalId')
            ->andWhere('t.groupe = :groupeId')
            ->setParameter('tribunalId', $tribunalId)
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
