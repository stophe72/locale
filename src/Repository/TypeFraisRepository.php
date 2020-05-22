<?php

namespace App\Repository;

use App\Entity\NoteDeFraisEntity;
use App\Entity\TypeFrais;
use App\Entity\TypeFraisEntity;
use App\Entity\MandataireEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method TypeFrais|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeFrais|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeFrais[]    findAll()
 * @method TypeFrais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeFraisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeFraisEntity::class);
    }

    public function countById(MandataireEntity $mandataire, int $id)
    {
        $qb = $this->createQueryBuilder('tf')
            ->select('COUNT(tf.id)')
            ->innerJoin(NoteDeFraisEntity::class, 'nf', Join::WITH, 'nf.typeFrais = tf')
            ->where('tf = :typeFraisId')
            ->andWhere('tf.groupe = :groupeId')
            ->setParameter('typeFraisId', $id)
            ->setParameter('groupeId', $mandataire->getGroupe()->getId());

        return intval($qb->getQuery()->getSingleScalarResult());
    }
}
