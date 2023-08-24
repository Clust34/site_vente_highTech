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

    public function save(Telephones $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

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

    public function findSearchData(SearchData $search): array
    {
        $query = $this->createQueryBuilder('t')
            ->select('t');

        if (!empty($search->getQuery())) {
            $query = $query->andWhere('t.marque LIKE :marque')
                ->setParameter('marque', "%{$search->getQuery()}%");
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

    //    public function findOneBySomeField($value): ?Telephones
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
