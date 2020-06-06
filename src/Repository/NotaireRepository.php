<?php

namespace App\Repository;

use App\Entity\NotaireEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NotaireEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotaireEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotaireEntity[]    findAll()
 * @method NotaireEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotaireEntity::class);
    }
}
