<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Telephones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Telephones>
 *
 * @method Telephones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telephones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telephones[]    findAll()
 * @method Telephones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelephonesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telephones::class);
    }

    /**
     * Save an article in DB
     *
     * @param Telephones $entity
     * @param boolean $flush
     * @return void
     */
    public function save(Telephones $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove an article in DB
     *
     * @param Telephones $entity
     * @param boolean $flush
     * @return void
     */
    public function remove(Telephones $entity, bool $flush = true): void
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
        $query = $this->createQueryBuilder('tel')
            ->select('tel');

        if ($actif) {
            $query->where('tel.enable = :enable')
                ->setParameter('enable', $actif);
        }

        return $query
            ->orderBy('tel.createdAt', 'DESC')
            ->groupBy('tel')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findSlug($search){
        $query = $this->createQueryBuilder('tel')
            ->select('tel')
            ->where('tel.slug = (:search)')
            ->setParameter('search', $search);

        return $query->getQuery()
            ->getResult();
    }
    /**
     * Find article by marque
     *
     * @param SearchData $search
     * @return array
     */
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
    //     * @return Telephones[] Returns an array of Telephones objects
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

       public function findOneBySlug($value): ?Telephones
       {
           return $this->createQueryBuilder('t')
               ->andWhere('t.slug = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
