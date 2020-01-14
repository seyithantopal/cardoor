<?php

namespace App\Repository;

use App\Entity\Orders;
use App\Entity\User;
use App\Entity\Cart;
use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }


    // /**
    //  * @return Orders[] Returns an array of Orders objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Orders
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOrdersByUser($user_id)
    {
        return $this->createQueryBuilder('o')
            ->select('o.userid', 'u.name', 'u.lastname', 'o.id', 'o.address', 'o.phone', 'o.city', 'o.shipinfo', 'o.status', 'o.amount')
            ->innerJoin(
                User::class,    // Entity
                'u',               // Alias
                Join::WITH,        // Join type
                'u.id = o.userid' // Join columns
            )
            ->where('o.userid = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllOrdersByStatus($status)
    {
        return $this->createQueryBuilder('o')
            ->select('o.userid', 'u.name', 'u.lastname', 'o.id', 'o.address', 'o.phone', 'o.city', 'o.shipinfo', 'o.status', 'o.amount')
            ->innerJoin(
                User::class,    // Entity
                'u',               // Alias
                Join::WITH,        // Join type
                'u.id = o.userid' // Join columns
            )
            ->where('o.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult()
            ;
    }

    public function updateOrders($id, $status, $shipinfo)
    {
        return $this->createQueryBuilder('o')
            //->select('o.userid', 'u.name', 'u.lastname', 'o.id', 'o.address', 'o.phone', 'o.city', 'o.shipinfo', 'o.status', 'o.amount')
           /* ->innerJoin(
                User::class,    // Entity
                'u',               // Alias
                Join::WITH,        // Join type
                'u.id = o.userid' // Join columns
            )*/
            ->update()
            ->set('o.status', ":status")
            ->set('o.shipinfo', ":shipinfo")
            ->where('o.id = :id')
            ->setParameter('id', $id)
            ->setParameter('status', $status)
            ->setParameter('shipinfo', $shipinfo)
            ->getQuery()
            ->execute()
            //->getResult()
            ;
    }
}
