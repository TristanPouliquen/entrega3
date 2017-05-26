<?php
namespace Entity40;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;


class HotelRepository extends EntityRepository
{
    public function getFiltered($data)){
        $queryBuilder = $this->createQueryBuilder('hotel')
                    ->select('hotel.*');

        if ($data["city"]) {
          $queryBuilder->join('hotel.address', 'address')
            ->andWhere('address.city = :city')
            ->setParameter('city', $data["city"]);
        }

        if ($data['name']) {
          $queryBuilder->andWhere("hotel.name LIKE :name")
            ->setParameter("name", "%{$data["name"]}%");
        }

        if ($data["rating"]) {
          $queryBuilder->andWhere('hotel.star_rating >= :rating')
            ->setParameter("rating", $data["rating"]);
        }

        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
}
