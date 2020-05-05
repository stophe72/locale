<?php

namespace App\Repository;

use App\Entity\UserEntity;
use App\Entity\VisiteEntity;
use App\Models\CalendrierVisiteFilter;
use App\Models\VisiteFilter;
use App\Util\Util;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method VisiteEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisiteEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisiteEntity[]    findAll()
 * @method VisiteEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisiteEntity::class);
    }

    public function getFromFilter(UserEntity $user, VisiteFilter $visiteFilter)
    {
        $qb = $this->createQueryBuilder('v');
        $qb->innerJoin('v.majeur', 'm')
            ->innerJoin('m.user', 'u', Join::WITH, $qb->expr()->eq('m.user', ':userId'))
            ->setParameter('userId', $user->getId())
            ->orderBy('v.date', 'DESC')
            ->addOrderBy('m.nom', 'ASC')
            ->addOrderBy('m.prenom', 'ASC');


        if ($visiteFilter->getMajeurId()) {
            $qb->andWhere('m = :majeurId')
                ->setParameter('majeurId', $visiteFilter->getMajeurId());
        }
        if ($visiteFilter->getDateDebut() && $visiteFilter->getDateFin()) {
            $dates = Util::orderDates($visiteFilter->getDateDebut(), $visiteFilter->getDateFin());
            $visiteFilter->setDateDebut($dates[0]);
            $visiteFilter->setDateFin($dates[1]);
        }
        if ($visiteFilter->getDateDebut()) {
            $qb->andWhere('v.date >= :dateDebut')
                ->setParameter('dateDebut', $visiteFilter->getDateDebut());
        }
        if ($visiteFilter->getDateFin()) {
            $qb->andWhere('v.date <= :dateFin')
                ->setParameter('dateFin', $visiteFilter->getDateFin());
        }

        return $qb->getQuery()->getResult();
    }

    public function getFromCalendrierFilter(UserEntity $user, CalendrierVisiteFilter $visiteFilter)
    {
        $qb = $this->createQueryBuilder('v');
        $qb->innerJoin('v.majeur', 'm')
            ->innerJoin('m.user', 'u', Join::WITH, 'm.user = :userId')
            ->andWhere('m = :majeurId')
            ->andWhere('YEAR(v.date) = :annee')
            ->setParameter('userId', $user->getId())
            ->setParameter('majeurId', $visiteFilter->getMajeurId())
            ->setParameter('annee', $visiteFilter->getAnnee());

        return $qb->getQuery()->getResult();
    }
}
