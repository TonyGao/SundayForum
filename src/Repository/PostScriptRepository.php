<?php

namespace App\Repository;

use App\Entity\PostScript;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostScript|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostScript|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostScript[]    findAll()
 * @method PostScript[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostScriptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostScript::class);
    }

    // /**
    //  * @return PostScript[] Returns an array of PostScript objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostScript
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
