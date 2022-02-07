<?php

namespace App\Repository;

use App\Entity\PostCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostCategoryRepository extends ServiceEntityRepository
{
  private $em;
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, PostCategory::class);
    $this->em = $this->getEntityManager();
  }

  public function likeName(string $categoryName): ?PostCategory
  {
    $qb = $this->em->createQueryBuilder();
    $qb->select('c')
        ->from('App\Entity\PostCategory', 'c')
        ->where('c.title LIKE :name')
        ->setParameter('name', '%'.$categoryName.'%');
    $categories = $qb->getQuery()->getResult();

    return $categories;
  }

  /**
   * Select all category name to an array
   */
  public function findAllTitletoArray()
  {
    $qb = $this->em->createQueryBuilder();
    return $qb->select('c.title')
        ->from('App\Entity\PostCategory', 'c')
        ->getQuery()->getArrayResult();
  }
}
