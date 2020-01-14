<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
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
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */

    public function findByExampleField($car_id)
    {
        return $this->createQueryBuilder('c')
            ->select('u.name', 'u.lastname', 'c.comment', 'u.image', 'u.id', 'c.rate', 'c.created_at')
            ->innerJoin(
                User::class,    // Entity
                'u',               // Alias
                Join::WITH,        // Join type
                'u.id = c.userid' // Join columns
            )
            ->where('c.carid = :car_id')
            ->andWhere('c.status = 1')
            ->setParameter('car_id', $car_id)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findComments()
    {
        return $this->createQueryBuilder('c')
            ->select('u.id', 'u.name', 'u.lastname', 'c.id', 'c.comment', 'c.userid', 'c.status', 'car.title', 'c.rate', 'c.ip', 'c.created_at', 'c.updated_at')
            ->innerJoin(
                User::class,    // Entity
                'u',               // Alias
                Join::WITH,        // Join type
                'u.id = c.userid' // Join columns
            )
            ->innerJoin(
                Car::class,    // Entity
                'car',               // Alias
                Join::WITH,        // Join type
                'c.carid = car.id' // Join columns
            )
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneComment($c_id)
    {
        return $this->createQueryBuilder('c')
            ->select('u.name', 'u.lastname', 'c.id', 'c.comment', 'c.userid', 'c.status', 'car.title', 'c.rate', 'c.ip', 'c.created_at', 'c.updated_at')
            ->innerJoin(
                User::class,    // Entity
                'u',               // Alias
                Join::WITH,        // Join type
                'u.id = c.userid' // Join columns
            )
            ->innerJoin(
                Car::class,    // Entity
                'car',               // Alias
                Join::WITH,        // Join type
                'c.carid = car.id' // Join columns
            )
            ->where('c.id = :c_id')
            ->orderBy('c.id', 'DESC')
            ->setParameter('c_id', $c_id)
            ->getQuery()
            ->getResult()
            ;
    }
}
