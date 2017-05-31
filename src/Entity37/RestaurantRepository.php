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

    public function getOpeningHours($restaurant, $date){
      $query = $this->createQueryBuilder('r')
        ->join('r.schedule', 's')
        ->where('r.name = :name')
        ->setParameter('name', $restaurant->getName())
        ->andWhere('s.day = :day')
        ->setParameter('day', date('w', $date))
        ->getQuery();

      $result = $query->getResult();

      return [];
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

      if ($data['sort']) {
            if ($data['sort'] == 'ciudad') {
              $queryBuilder->orderBy('restaurant.city', 'ASC');
            } else if ($data['sort'] == 'alfabetico') {
                $queryBuilder->orderBy('restaurant.name', 'ASC');
            } else if ($data['sort'] == 'estrellas') {
                $queryBuilder->orderBy('restaurant.star_rating', 'DESC');
            }
        }

      $query = $queryBuilder->getQuery();

      return $query->getResult();
    }
}
