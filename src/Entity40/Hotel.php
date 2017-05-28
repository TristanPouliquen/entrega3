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
     * @ORM\SequenceGenerator(sequenceName="hotel_ai", allocationSize=100, initialValue=1)
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
     * @var \Entity40\address
     *
     * @ORM\OneToOne(targetEntity="Entity40\address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="direccion_id", referencedColumnName="id", unique=true, onDelete="CASCADE")
     * })
     */
    private $address;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity40\Facility", mappedBy="hotel")
     */
    private $facilities;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity40\Reservation", mappedBy="hotel")
     * @ORM\OrderBy({'arrival': 'DESC'})
     */
    private $reservations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->facilities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getAverageNote() {
        $total = 0;
        $count = 0;
        foreach($this->reservations as $reservation){
            $review = $reservation->getReview();
            if ($review){
                $total += $review->getRating();
                $count++;
            }
	}

        return round($total / $count,2);
    }

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

    /**
     * Set address
     *
     * @param \Entity40\address $address
     *
     * @return Hotel
     */
    public function setAddress(\Entity40\address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \Entity40\address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add facility
     *
     * @param \Entity40\Facility $facility
     *
     * @return Hotel
     */
    public function addFacility(\Entity40\Facility $facility)
    {
        $this->facilities[] = $facility;

        return $this;
    }

    /**
     * Remove facility
     *
     * @param \Entity40\Facility $facility
     */
    public function removeFacility(\Entity40\Facility $facility)
    {
        $this->facilities->removeElement($facility);
    }

    /**
     * Get facilities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacilities()
    {
        return $this->facilities;
    }

    /**
     * Add reservation
     *
     * @param \Entity40\reservation $reservation
     *
     * @return Hotel
     */
    public function addReservation(\Entity40\reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \Entity40\reservation $reservation
     */
    public function removeReservation(\Entity40\reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }


}
