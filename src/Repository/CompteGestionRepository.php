<?php

namespace App\Repository;

use App\Entity\CompteGestionEntity;
use App\Entity\UserEntity;
use App\Models\CompteGestionFilter;
use App\Util\Util;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function getFromFilter(UserEntity $user, CompteGestionFilter $filter)
    {
        $qb = $this->createQueryBuilder('cg');
        $qb->innerJoin('cg.typeOperation', 'to')
            ->innerJoin('cg.user', 'u', Join::WITH, $qb->expr()->eq('cg.user', ':userId'))
            ->setParameter('userId', $user->getId());

        // if ($filter->getMajeurNom()) {
        // $qb->andWhere('LOWER(m.nom) LIKE LOWER(:majeurNom)')
        // ->setParameter('majeurNom', '%' . $filter->getMajeurNom() . '%');
        // }
        if ($filter->getLibelle()) {
            $qb->andWhere('LOWER(m.libelle) LIKE LOWER(:libelle)')
                ->setParameter('libelle', '%' . $filter->getLibelle() . '%');
        }
        if ($filter->getDateDebut() && $filter->getDateFin()) {
            $dates = Util::orderDates($filter->getDateDebut(), $filter->getDateFin());
            $filter->setDateDebut($dates[0]);
            $filter->setDateFin($dates[1]);
        } else {
            if ($filter->getDateDebut()) {
                $qb->andWhere('cg.date >= :dateDebut')
                    ->setParameter('dateDebut', $filter->getDateDebut());
            }
            if ($filter->getDateFin()) {
                $qb->andWhere('cg.date <= :dateFin')
                    ->setParameter('dateFin', $filter->getDateFin());
            }
        }
        if ($filter->getTypeOperation()) {
            $qb->andWhere('to = :typeOperation')
                ->setParameter('typeOperation', $filter->getTypeOperation()->getId());
        }
        if ($filter->getMontant()) {
            $qb->andWhere('cg.montant = :montant')
                ->setParameter('montant', $filter->getMontant());
        }

        return $qb->getQuery()->getResult();
    }
}
