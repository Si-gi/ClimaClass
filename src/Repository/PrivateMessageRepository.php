<?php

namespace App\Repository;

use App\Entity\PrivateMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrivateMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrivateMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrivateMessage[]    findAll()
 * @method PrivateMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivateMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrivateMessage::class);
    }


    /**
     * @return array
     */
    public function getConv($receiver, $sender){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->
        createQuery('SELECT p 
                            FROM App\Entity\PrivateMessage p
                            WHERE p.receiver = :receiver AND p.sender = :sender 
                            OR p.receiver= :sender AND p.sender = :receiver
                            ')
            ->setParameter('receiver', $receiver)
            ->setParameter('sender', $sender);
        return $queryBuilder->execute();
    }

}
