<?php

namespace Entities\grupo40;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hotel
 *
 * @ORM\Table(name="hoteles",
 *   indexes={@ORM\Index(name="hoteles_pkey", columns={"id"})}
 * )
 * @ORM\Entity(repositoryClass="Entities\40\Repositories\HotelRepository.php")
 */
class Hotel {

  /**
   * @var integer
   *
   * @ORM\Column(name="id")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="nombre")
   */
  private $name;

  /**
   * @var integer
   *
   * @ORM\Column(name="nro_piezas")
   */
  private $number_rooms;

  /**
   * @var integer
   *
   * @ORM\Column(name="precio_pieza")
   */
  private $price_room;

  /**
   * @var integer
   *
   * @ORM\Column(name="estrellas")
   */
  private $star_rating;

  public function __construct($name, $number_rooms, $price_room, $star_rating){
    $this->name = $name;
    $this->number_rooms = $number_rooms;
    $this->price_room = $price_room;
    $this->star_rating = $star_rating;
  }

  public function getName(){
    return $this->name;
  }

  public function setName($name){
    $this->name = $name;
    return $this;
  }

  public function getNumberRooms(){
    return $this->number_rooms;
  }

  public function setNumberRooms($number){
    $this->number_rooms = $number;
    return this;
  }

  public function getPriceRoom(){
    return $this->price_room;
  }

  public function setPriceRoom($price){
    $this->price_room = $price;
    return $this;
  }

  public function getStarRating(){
    return $this->star_rating;
  }

  public function setStarRating($rating){
    $this->star_rating = $rating;
    return $this;
  }
}

