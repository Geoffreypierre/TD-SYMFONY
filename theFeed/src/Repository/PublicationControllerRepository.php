<?php

namespace App\Repository;

use App\Entity\PublicationController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PublicationController>
 *
 * @method PublicationController|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicationController|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicationController[]    findAll()
 * @method PublicationController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicationController::class);
    }

//    /**
//     * @return PublicationController[] Returns an array of PublicationController objects
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

//    public function findOneBySomeField($value): ?PublicationController
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
