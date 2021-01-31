<?php

namespace App\Repository;

use App\Entity\ProduitTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProduitTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitTranslation[]    findAll()
 * @method ProduitTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitTranslation::class);
    }
}
