<?php

namespace App\Repository;

use App\Entity\Tablettes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tablettes>
 *
 * @method Tablettes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tablettes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tablettes[]    findAll()
 * @method Tablettes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TablettesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tablettes::class);
    }

//    /**
//     * @return Tablettes[] Returns an array of Tablettes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tablettes
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
