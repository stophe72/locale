<?php

namespace App\Repository;

use App\Entity\AgenceBancaireEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AgenceBancaireEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgenceBancaireEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgenceBancaireEntity[]    findAll()
 * @method AgenceBancaireEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenceBancaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgenceBancaireEntity::class);
    }
}
