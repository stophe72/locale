<?php

namespace App\Repository;

use App\Entity\MandataireEntity;
use App\Entity\PriseEnChargeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PriseEnChargeEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriseEnChargeEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriseEnChargeEntity[]    findAll()
 * @method PriseEnChargeEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriseEnChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriseEnChargeEntity::class);
    }

    public function getAlertes(MandataireEntity $mandataire)
    {
        $qb = $this->createQueryBuilder('pec');
        $qb->innerJoin('pec.majeur', 'm')
            ->innerJoin('m.groupe', 'g')
            ->where('g = :groupeId')
            ->andWhere('pec.traite = 0')
            ->andWhere('pec.dateFin < DATE_ADD(CURRENT_DATE(), pec.seuilAlerte, \'week\')')
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return $qb->getQuery()->getResult();
    }
}
