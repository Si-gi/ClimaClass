<?php

namespace App\Repository;

use App\Entity\School;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method School|null find($id, $lockMode = null, $lockVersion = null)
 * @method School|null findOneBy(array $criteria, array $orderBy = null)
 * @method School[]    findAll()
 * @method School[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, School::class);
    }


    /**
     * @param null $state
     * @param null $city
     * @param null $name
     * @param null $latitude
     * @param null $longitude
     * @return void array
     */
    public function findByQuery($state = null,$city = null,$name = null,$latitude = null,$longitude = null){

            $query = $this->createQueryBuilder('school');
            if($state != null){
                $query->Where('school.State = :state')
                ->setParameter('state', $state);
            }
            if($city != null){
                $query->orWhere('school.city = :city')
                    ->setParameter('city', $city);
            }
            if($name != null){
                $query->orWhere('school.Name = :name')
                    ->setParameter('name', $name);
            }
            if($latitude != null){
                $query->orWhere('school.latitude > :latitudeA')
                    ->andWhere('school.latitude < :$latitudeB' )
                    ->setParameter('latitudeA', $latitude-200);
                    ->setParameter('latitudeB', $latitude+200);
            }
            if($longitude != null){
                $query->orWhere('school.longitude > :longitudeA')
                    ->andWhere('school.longitude < :longitudeB')
                    ->setParameter('longitudeA', $longitude-200)
                    ->setParameter('longitudeB', $longitude+200);
            }

            $query->setMaxResults(4)
            ->getQuery()
            ->getResult();
            return $query;
    }
    // /**
    //  * @return School[] Returns an array of School objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?School
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
