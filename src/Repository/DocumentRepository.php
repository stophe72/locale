<?php

namespace App\Repository;

use App\Entity\DocumentEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocumentEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentEntity[]    findAll()
 * @method DocumentEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentEntity::class);
    }
}
