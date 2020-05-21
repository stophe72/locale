<?php

namespace App\Repository;

use App\Entity\CompteGestionEntity;
use App\Entity\DonneeBancaireEntity;
use App\Entity\MandataireEntity;
use App\Entity\MajeurEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

    public function findByMajeur(MandataireEntity $mandataire, MajeurEntity $majeur)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->innerJoin('b.majeur', 'm')
            ->where('m = :majeurId')
            ->andWhere('m.groupe = :groupeId')
            ->setParameter('majeurId', $majeur->getId())
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return $qb->getQuery()->getResult();
    }

    public function countByCompteGestion(MandataireEntity $mandataire, int $id)
    {
        $qb = $this->createQueryBuilder('db');
        $qb->select('COUNT(db.id)')
            ->innerJoin(CompteGestionEntity::class, 'cg', Join::WITH, 'cg.donneeBancaire = db')
            ->innerJoin('db.majeur', 'm')
            ->where('m.groupe = :groupeId')
            ->andWhere('db = :donneeBancaireId')
            ->setParameter('groupeId', $mandataire->getGroupe()->getId())
            ->setParameter('donneeBancaireId', $id);

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
