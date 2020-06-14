<?php

namespace App\Repository;

use App\Entity\MajeurEntity;
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

    public function getAlertes(MandataireEntity $mandataire, MajeurEntity $majeur = null)
    {
        $qb = $this->createQueryBuilder('pec');
        $qb->innerJoin('pec.majeur', 'm')
            ->innerJoin('pec.typePriseEnCharge', 'tpec')
            ->innerJoin('m.groupe', 'g')
            ->where('g = :groupeId')
            ->andWhere('pec.traite = 0')
            ->andWhere('tpec.seuilAlerte > 0')
            ->andWhere('pec.dateFin < DATE_ADD(CURRENT_DATE(), tpec.seuilAlerte, \'week\')')
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        if ($majeur) {
            $qb->andWhere('m =:majeurId')
                ->setParameter('majeurId', $majeur->getId());
        }

        return $qb->getQuery()->getResult();
    }
}
