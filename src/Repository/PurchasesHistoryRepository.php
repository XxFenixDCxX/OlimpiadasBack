<?php

namespace App\Repository;

use App\Entity\PurchasesHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PurchasesHistory>
 *
 * @method PurchasesHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchasesHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchasesHistory[]    findAll()
 * @method PurchasesHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchasesHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PurchasesHistory::class);
    }

    //    /**
    //     * @return PurchasesHistory[] Returns an array of PurchasesHistory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PurchasesHistory
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
