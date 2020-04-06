<?php

namespace App\Repository;

use App\Entity\UserEntity;
use App\Entity\VisiteEntity;
use App\Models\VisiteFilter;
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
            ->innerJoin('v.user', 'u', Join::WITH, $qb->expr()->eq('v.user', ':userId'))
            ->setParameter('userId', $user->getId())
            ->orderBy('v.date', 'DESC')
            ->addOrderBy('m.nom', 'ASC')
            ->addOrderBy('m.prenom', 'ASC');

        if ($visiteFilter->getMajeurNom()) {
            $qb->andWhere('LOWER(m.nom) LIKE LOWER(:majeurNom)')
                ->setParameter('majeurNom', '%' . $visiteFilter->getMajeurNom() . '%');
        }
        if ($visiteFilter->getDateDebut() && $visiteFilter->getDateFin()) {
            if ($visiteFilter->getDateDebut()->getTimestamp() > $visiteFilter->getDateFin()->getTimestamp()) {
                $d = $visiteFilter->getDateFin();
                $visiteFilter->setDateFin($visiteFilter->getDateDebut());
                $visiteFilter->setDateDebut($d);
            }
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
}
