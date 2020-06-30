<?php
/**
 * Created by PhpStorm.
 * User: si_gi
 * Date: 11/02/2019
 * Time: 15:08
 */

namespace App\Repository;

//src/Repository/ContactRepository.php
use App\Entity\Contacts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Contacts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contacts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contacts[]    findAll()
 * @method Contacts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ContactsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contacts::class);
    }

    public function getContactWhere($iduser, $idcontact){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('ct')
            ->from('App:Contacts', 'ct')
            ->where('ct.idUser= :iduser')
            ->andWhere('ct.idContact = :idcontact')
            ->orWhere('ct.idUser= :idcontact')
            ->andWhere('ct.idContact = :iduser')
            ->setParameter('iduser', $iduser )
            ->setParameter('idcontact',$idcontact);
        return $queryBuilder->getQuery()->execute();
    }
}
