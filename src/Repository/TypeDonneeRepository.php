<?php

namespace App\Repository;

use App\Entity\TypeDonnee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeDonnee|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDonnee|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDonnee[]    findAll()
 * @method TypeDonnee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDonneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDonnee::class);
    }

    // /**
    //  * @return TypeDonnee[] Returns an array of TypeDonnee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeDonnee
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
