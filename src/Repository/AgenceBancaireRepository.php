<?php

namespace App\Repository;

use App\Entity\AgenceBancaireEntity;
use App\Entity\DonneeBancaireEntity;
use App\Entity\MandataireEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

/**
 * @method AgenceBancaireEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgenceBancaireEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgenceBancaireEntity[]    findAll()
 * @method AgenceBancaireEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenceBancaireRepository extends ServiceEntityRepository
{
    public function __construct(PersistenceManagerRegistry $registry)
    {
        parent::__construct($registry, AgenceBancaireEntity::class);
    }

    public function countByDonneeBancaire(MandataireEntity $mandataire, int $agenceBancaireId)
    {
        $qb = $this->createQueryBuilder('ab');
        $qb->select('COUNT(ab.id)')
            ->innerJoin(DonneeBancaireEntity::class, 'db', Join::WITH, 'db.agenceBancaire = ab')
            ->where('ab = :agenceBancaireId')
            ->andWhere('ab.groupe = :mandataireGroupeId')
            ->setParameter('agenceBancaireId', $agenceBancaireId)
            ->setParameter('mandataireGroupeId', $mandataire->getGroupe()->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
