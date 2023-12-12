<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Ordinateurs;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Ordinateurs>
 *
 * @method Ordinateurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordinateurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordinateurs[]    findAll()
 * @method Ordinateurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdinateursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordinateurs::class);
    }

    public function save(Ordinateurs $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ordinateurs $entity, bool $flush = true): void
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
        $query = $this->createQueryBuilder('o')
            ->select('o');

        if ($actif) {
            $query->where('o.actif = :actif')
                ->setParameter('actif', $actif);
        }

        return $query
            ->orderBy('o.created_at', 'DESC')
            ->groupBy('o')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findSearchData(SearchData $search): array
    {
        $query = $this->createQueryBuilder('o')
            ->select('o', 'm')
            ->innerJoin('o.marque', 'm');

        // if (!empty($search->getQuery())) {
        //     $query->andWhere('o.nom LIKE :nom')
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
    //     * @return Ordinateurs[] Returns an array of Ordinateurs objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findOneBySlug($value): ?Ordinateurs
       {
           return $this->createQueryBuilder('o')
               ->andWhere('o.slug = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
