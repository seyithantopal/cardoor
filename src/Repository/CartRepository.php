<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\Car;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function findCart()
    {
        return $this->createQueryBuilder('c')
            ->select('c.id', 'c.pickupdate', 'c.returndate', 'c.status', 'car.id as carid', 'car.image', 'car.title', 'car.price')
            ->innerJoin(
                Car::class,    // Entity
                'car',               // Alias
                Join::WITH,        // Join type
                'car.id = c.carid' // Join columns
            )
            ->getQuery()
            ->getResult()
            ;
    }

    public function findCartsByUser($user_id)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id', 'c.pickupdate', 'c.returndate', 'c.status', 'car.id as carid', 'car.image', 'car.title', 'car.price', 'DATE_DIFF(c.returndate, c.pickupdate) AS days', '(car.price * DATE_DIFF(c.returndate, c.pickupdate)) AS total')
            ->innerJoin(
                Car::class,    // Entity
                'car',               // Alias
                Join::WITH,        // Join type
                'car.id = c.carid' // Join columns
            )
            ->where('c.userid = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findTotalAmount($user_id)
    {
        $query = $this->createQueryBuilder('c')
            ->select('SUM((DATE_DIFF(c.returndate, c.pickupdate) * car.price)) AS totalPrice', 'c.id', 'car.id AS carId', 'c.userid', 'car.price')
            ->innerJoin(
                Car::class,    // Entity
                'car',               // Alias
                Join::WITH,        // Join type
                'car.id = c.carid' // Join columns
            )
            ->where('c.userid = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getResult()
            ;
        return $query[0]['totalPrice'] == null ? 0 : $query[0]['totalPrice'];
    }

    public function deleteCartByUser($user_id)
    {
        return $this->createQueryBuilder('c')
            ->where('c.userid = :user_id')
            ->setParameter('user_id', $user_id)
            ->delete()
            ->getQuery()
            ->execute()
            ;
    }



    // /**
    //  * @return Cart[] Returns an array of Cart objects
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
    public function findOneBySomeField($value): ?Cart
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
