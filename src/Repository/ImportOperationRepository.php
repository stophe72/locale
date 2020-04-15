<?php

namespace App\Repository;

use App\Entity\ImportOperationEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImportOperationEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImportOperationEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImportOperationEntity[]    findAll()
 * @method ImportOperationEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImportOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImportOperationEntity::class);
    }

    public function findByMatchLibelle(string $text)
    {
        $qb = $this->createQueryBuilder('io');
        $qb->where('io.libelle LIKE :libelle')
            ->setParameter('libelle', '%' . $text . '%');

        return $qb->getQuery()->getResult();
    }
}
