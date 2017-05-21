<?php
namespace Entity40;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;


class AddressRepository extends EntityRepository
{
    public function getDistinctCities(){
        $query = $this->createQueryBuilder('address')
                    ->select('address.ciudad')
                    ->distinct()
                    ->getQuery();

        return $query->getResult();
    }
}
