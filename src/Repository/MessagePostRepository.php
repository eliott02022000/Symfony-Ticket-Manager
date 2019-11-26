<?php

namespace App\Repository;

use App\Entity\MessagePost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MessagePost|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessagePost|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessagePost[]    findAll()
 * @method MessagePost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagePostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessagePost::class);
    }

    // /**
    //  * @return MessagePost[] Returns an array of MessagePost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessagePost
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
