<?php

namespace App\Repository;

use App\Entity\CompteGestionEntity;
use App\Entity\DonneeBancaireEntity;
use App\Entity\MajeurEntity;
use App\Entity\TypeCompteEntity;
use App\Entity\TypeOperationEntity;
use App\Entity\UserEntity;
use App\Models\CompteGestionFilter;
use App\Util\Util;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompteGestionEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteGestionEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteGestionEntity[]    findAll()
 * @method CompteGestionEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteGestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteGestionEntity::class);
    }

    public function getFromFilter(UserEntity $user, DonneeBancaireEntity $donneeBancaire, CompteGestionFilter $filter)
    {
        $qb = $this->createQueryBuilder('cg');
        $qb->innerJoin('cg.typeOperation', 'to')
            ->innerJoin('cg.donneeBancaire', 'db', Join::WITH, $qb->expr()->eq('db', ':donneeBancaireId'))
            ->innerJoin('cg.user', 'u', Join::WITH, $qb->expr()->eq('cg.user', ':userId'))
            ->setParameter('donneeBancaireId', $donneeBancaire->getId())
            ->setParameter('userId', $user->getId())
            ->addOrderBy('cg.date', 'DESC');

        if ($filter->getLibelle()) {
            $qb->andWhere('LOWER(m.libelle) LIKE LOWER(:libelle)')
                ->setParameter('libelle', '%' . $filter->getLibelle() . '%');
        }
        if ($filter->getDateDebut() && $filter->getDateFin()) {
            $dates = Util::orderDates($filter->getDateDebut(), $filter->getDateFin());
            $filter->setDateDebut($dates[0]);
            $filter->setDateFin($dates[1]);
        }
        if ($filter->getDateDebut()) {
            $qb->andWhere('cg.date >= :dateDebut')
                ->setParameter('dateDebut', $filter->getDateDebut());
        }
        if ($filter->getDateFin()) {
            $qb->andWhere('cg.date <= :dateFin')
                ->setParameter('dateFin', $filter->getDateFin());
        }

        if ($filter->getTypeOperation()) {
            $qb->andWhere('to = :typeOperation')
                ->setParameter('typeOperation', $filter->getTypeOperation()->getId());
        }
        if ($filter->getMontant()) {
            $qb->andWhere('cg.montant = :montant')
                ->setParameter('montant', $filter->getMontant());
        }

        return $qb;
    }

    public function getSoldes(MajeurEntity $majeur, int $annee)
    {
        $qb = $this->createQueryBuilder('cg');
        $qb->select('tc.libelle AS typeCompte, SUM(cg.montant * cg.nature) AS solde')
            ->innerJoin('cg.donneeBancaire', 'db')
            ->innerJoin(TypeCompteEntity::class, 'tc', Join::WITH, 'tc.id = db.typeCompte')
            ->andWhere('db.majeur = :majeurId')
            ->andWhere('cg.date BETWEEN :from AND :to')
            ->groupBy('tc.id')
            ->setParameter('majeurId', $majeur->getId())
            ->setParameter('from', $annee . '-01-01')
            ->setParameter('to', $annee . '-12-31')
            ->addOrderBy('tc.libelle', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function getRecettesParTypeOperation(MajeurEntity $majeur, int $annee)
    {
        return $this->getMontantsParTypeOperation($majeur, $annee);
    }

    public function getDepensesParTypeOperation(MajeurEntity $majeur, int $annee)
    {
        return $this->getMontantsParTypeOperation($majeur, $annee, -1);
    }

    private function getMontantsParTypeOperation(MajeurEntity $majeur, int $annee, int $nature = 1)
    {
        $qb = $this->createQueryBuilder('cg');
        $qb->select('ope.libelle AS libelle, SUM(cg.montant * cg.nature) AS montant')
            ->innerJoin('cg.typeOperation', 'ope')
            ->innerJoin('cg.donneeBancaire', 'db')
            ->andWhere('db.majeur = :majeurId')
            ->andWhere('cg.date BETWEEN :from AND :to')
            ->andWhere('cg.nature = :nature')
            ->groupBy('ope.id')
            ->setParameter('majeurId', $majeur->getId())
            ->setParameter('from', $annee . '-01-01')
            ->setParameter('to', $annee . '-12-31')
            ->setParameter('nature', $nature)
            ->addOrderBy('ope.libelle', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
