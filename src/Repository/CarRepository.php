<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */

    public function findByExampleField()
    {
        return $this->createQueryBuilder('c')
            ->join(Category::class, 'ct')
            ->where('c.category = ct.id and c.status = 1')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneCar($car_id)
    {
        return $this->createQueryBuilder('c')
            ->join(User::class, 'u')
            ->where('c.userid = u.id and c.id = :car_id')
            ->setParameter('car_id', $car_id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findUser($car_id)
    {
        return $this->createQueryBuilder('c')
            ->select('u.id', 'u.name', 'u.lastname')
            ->innerJoin(
                User::class,    // Entity
                'u',               // Alias
                Join::WITH,        // Join type
                'u.id = c.userid' // Join columns
            )
            ->where('c.id = :car_id')
            ->setParameter('car_id', $car_id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByExampleFieldById($id)
    {
        return $this->createQueryBuilder('c')
            ->join(Category::class, 'ct')
            ->where('c.category = ct.id and c.status = 1 and c.userid = :u_id')
            ->setParameter('u_id', $id)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Car
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
