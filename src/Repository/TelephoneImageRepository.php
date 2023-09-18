<?php

namespace App\Repository;

use App\Entity\TelephoneImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TelephoneImage>
 *
 * @method TelephoneImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TelephoneImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TelephoneImage[]    findAll()
 * @method TelephoneImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelephoneImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TelephoneImage::class);
    }

//    /**
//     * @return TelephoneImage[] Returns an array of TelephoneImage objects
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

//    public function findOneBySomeField($value): ?TelephoneImage
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
