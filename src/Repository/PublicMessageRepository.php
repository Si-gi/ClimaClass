<?php

namespace App\Repository;

use App\Entity\PublicMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublicMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicMessage[]    findAll()
 * @method PublicMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicMessage::class);
    }

    /**
     * @return array
     */
    public function getConv($receiver, $sender){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->
        createQuery('SELECT p 
                            FROM App\Entity\PublicMessage p
                            WHERE p.receiver = :receiver AND p.sender = :sender 
                            OR p.receiver= :sender AND p.sender = :receiver
                            
                            ')
            ->setParameter('receiver', $receiver)
            ->setParameter('sender', $sender);
        return $queryBuilder->execute();
    }

    // /**
    //  * @return PublicMessage[] Returns an array of PublicMessage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PublicMessage
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    // public function findMessageRecus($value)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->where('p.idClasseEmeteur= :val OR p.idClasseDestinataire = :val ')
    //         ->setParameter('val', $value)
    //         ->groupBy('p.idClasseEmeteur')
    //         ->addGroupBy('p.idClasseDestinataire')
    //         ->orderBy('p.id', 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
}
