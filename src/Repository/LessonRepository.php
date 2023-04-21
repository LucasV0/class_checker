<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Tags\author;



/**
 * @extends ServiceEntityRepository<Lesson>
 * @author Baptiste Caron
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    public function save(Lesson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Lesson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return lesson[]
     */
    public function findBySession($val) : array
   {
       return $this->createQueryBuilder('l')
           ->leftJoin('l.Period', 'p')
           ->andwhere('l.Period = p.id')
           ->andWhere('p.Session = :val')
           ->setParameter('val', $val)
           ->getQuery()
           ->getResult()
         ;

    }
    //public function triAction()
    //{
      //  $em = $this->getDoctrine()->getManager();
        //$listeLessonSession=$em->getRepository('app:lesson')->findBySession();
        //$vue = 'lesson/index.html.twig';
        //return $this->render($vue, array(
          //  'liste'=>$listeLessonSession,
        //));
    //}
//    /**
//     * @return Lesson[] Returns an array of Lesson objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Lesson
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
