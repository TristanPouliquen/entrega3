<?php

namespace Entity40;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hotel
 *
 * @ORM\Table(name="hoteles", indexes={@ORM\Index(name="hoteles_pkey", columns={"id"})})
 * @ORM\Entity
 */
class Hotel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="hoteles_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="nro_piezas", type="integer")
     */
    private $number_rooms;

    /**
     * @var integer
     *
     * @ORM\Column(name="precio_pieza", type="integer")
     */
    private $price_room;

    /**
     * @var integer
     *
     * @ORM\Column(name="estrellas", type="integer")
     */
    private $star_rating;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Hotel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set numberRooms
     *
     * @param integer $numberRooms
     *
     * @return Hotel
     */
    public function setNumberRooms($numberRooms)
    {
        $this->number_rooms = $numberRooms;

        return $this;
    }

    /**
     * Get numberRooms
     *
     * @return integer
     */
    public function getNumberRooms()
    {
        return $this->number_rooms;
    }

    /**
     * Set priceRoom
     *
     * @param integer $priceRoom
     *
     * @return Hotel
     */
    public function setPriceRoom($priceRoom)
    {
        $this->price_room = $priceRoom;

        return $this;
    }

    /**
     * Get priceRoom
     *
     * @return integer
     */
    public function getPriceRoom()
    {
        return $this->price_room;
    }

    /**
     * Set starRating
     *
     * @param integer $starRating
     *
     * @return Hotel
     */
    public function setStarRating($starRating)
    {
        $this->star_rating = $starRating;

        return $this;
    }

    /**
     * Get starRating
     *
     * @return integer
     */
    public function getStarRating()
    {
        return $this->star_rating;
    }
}

