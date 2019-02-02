<?php

namespace App\Repository;

use App\Entity\SlotAllowed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SlotAllowed|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlotAllowed|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlotAllowed[]    findAll()
 * @method SlotAllowed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlotAllowedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SlotAllowed::class);
    }

    // /**
    //  * @return SlotAllowed[] Returns an array of SlotAllowed objects
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
    public function findOneBySomeField($value): ?SlotAllowed
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
