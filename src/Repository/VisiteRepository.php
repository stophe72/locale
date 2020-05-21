<?php

namespace App\Repository;

use App\Entity\MajeurEntity;
use App\Entity\MandataireEntity;
use App\Entity\VisiteEntity;
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

    public function getFromMajeurAndAnnee(MandataireEntity $mandataire, MajeurEntity $majeur, int $annee)
    {
        if (!$mandataire) {
            return [];
        }
        $qb = $this->createQueryBuilder('v');
        $qb->innerJoin('v.majeur', 'm')
            ->innerJoin('m.groupe', 'g')
            ->innerJoin(MandataireEntity::class, 'ma', Join::WITH, 'ma.groupe = g AND g = :groupeId')
            ->andWhere('m = :majeurId')
            ->andWhere('YEAR(v.date) = :annee')
            ->setParameter('groupeId', $mandataire->getGroupe()->getId())
            ->setParameter('majeurId', $majeur->getId())
            ->setParameter('annee', $annee);

        return $qb->getQuery()->getResult();
    }
}
