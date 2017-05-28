<?php

namespace Entity37;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ReviewRestaurantRepository extends EntityRepository
{

  public function getLatestReviewsFirst($restaurant, $limit =5){
    $query = $this->createQueryBuilder('rr')
      ->join('rr.review', 'rrr')
      ->join('rr.restaurant', 'r')
      ->where('r.name = :name')
      ->setParameter('name', $restaurant->getName())
      ->orderBy('rrr.date', 'DESC')
      ->setMaxResults((int)$limit)
      ->getQuery();

    return $query->getResult();
  }
}
