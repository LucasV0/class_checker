<?php

namespace App\Repository;

use App\Entity\Absence;
use App\Entity\Justify;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Absence>
 * @author Caron Baptiste
 * @method Absence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Absence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Absence[]    findAll()
 * @method Absence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Absence::class);
    }

    public function save(Absence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Absence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

     /**
     * @return Absence[] Returns an array of Absence objects
     */
    public function findByExampleField1(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.justify', 'j')
            ->andWhere('a.justify = j.id')
            ->andWhere('j.status = 1')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Absence[] Returns an array of Absence objects
     */
    public function findByExampleField2(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.justify', 'j')
            ->andWhere('a.justify = j.id')
            ->andWhere('j.status = 2')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     *  @return Absence[] Returns an array of Absence objects
     */
    public function findByExampleField0(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.justify', 'j')
            ->andWhere('a.justify = j.id')
            ->andWhere('j.status = 0')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Absence[] Returns an array of Absence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Absence
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
