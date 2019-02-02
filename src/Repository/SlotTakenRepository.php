<?php

namespace App\Repository;

use App\Entity\SlotTaken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SlotTaken|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlotTaken|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlotTaken[]    findAll()
 * @method SlotTaken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlotTakenRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SlotTaken::class);
    }

    // /**
    //  * @return SlotTaken[] Returns an array of SlotTaken objects
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
    public function findOneBySomeField($value): ?SlotTaken
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
