<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Tablettes;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function save(Tablettes $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tablettes $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Find the latest article with limit or not and all article or just enable article.
     *
     * @param int|null $limit
     * @param bool     $actif
     *
     * @return array
     */
    public function findLatest(int $limit = null, bool $actif = true): array
    {
        $query = $this->createQueryBuilder('t')
            ->select('t');

        if ($actif) {
            $query->where('t.actif = :actif')
                ->setParameter('actif', $actif);
        }

        return $query
            ->orderBy('t.ceated_at', 'DESC')
            ->groupBy('t')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findSearchData(SearchData $search): array
    {
        $query = $this->createQueryBuilder('t')
            ->select('t', 'm')
            ->innerJoin('t.marque', 'm');

        // if (!empty($search->getQuery())) {
        //     $query->andWhere('t.nom LIKE :nom')
        //         ->setParameter('nom', "%{$search->getQuery()}%");
        // }

        if (!empty($search->getMarques())) {
            $query->andWhere('m.id IN (:marques)')
                ->setParameter('marques', $search->getMarques());
        }

        return $query->getQuery()
            ->getResult();
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
