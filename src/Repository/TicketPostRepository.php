<?php

namespace App\Repository;

use App\Entity\TicketPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TicketPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketPost[]    findAll()
 * @method TicketPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketPost::class);
    }

    // /**
    //  * @return TicketPost[] Returns an array of TicketPost objects
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
    public function findOneBySomeField($value): ?TicketPost
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
