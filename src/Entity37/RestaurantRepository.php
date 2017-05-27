<?php
namespace Entity37;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;


class RestaurantRepository extends EntityRepository
{
    public function getDistinctCities(){
        $query = $this->createQueryBuilder('restaurant')
                    ->select('restaurant.city')
                    ->distinct()
                    ->getQuery();
        return $query->getResult();
    }

    public function getLatestReviewsFirst(){
      $query = $this->createQueryBuilder('r')
        ->select('rrr')
        ->join('r.reservations', 'rr')
        ->join('rr.reservation', 'rrr')
        ->orderBy('rrr.date', 'DESC')
        ->getQuery();

      return $query->getResult();
    }

    public function getFiltered($data){
      $queryBuilder = $this->createQueryBuilder('restaurant')
                  ->select('restaurant');

      if ($data["city"]){
        $queryBuilder->andWhere('restaurant.city = :city')
          ->setParameter("city", $data["city"]);
      }

      if ($data["name"]){
        $queryBuilder->andWhere('restaurant.name LIKE :name')
          ->setParameter('name', "%" . $data['name'] . "%");
      }

      if ($data["rating"]){
        $queryBuilder->andWhere('restaurant.star_rating >= :rating')
          ->setParameter('rating', $data["rating"]);
      }

      $query = $queryBuilder->getQuery();

      return $query->getResult();
    }
}
