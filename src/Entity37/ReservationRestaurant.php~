<?php

namespace Entity37;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationRestaurant
 *
 * @ORM\Table(name="reservarestaurante", indexes={@ORM\Index(name="reservarestaurante_pkey", columns={"idreserva"})})
 * @ORM\Entity
 */
class ReservationRestaurant
{
    /**
     * @var \Entity37\Reservation
     *
     * @ORM\OneToOne(targetEntity="Entity37\Reservation", inversedBy="restaurantReservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idreserva", referencedColumnName="idreserva", unique=true)
     * })
     */
    private $reservation;

    /**
     * @var \Entity37\Client
     *
     * @ORM\ManyToOne(targetEntity="Entity37\Client", inversedBy="reservations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="telefono", referencedColumnName="telefono")
     * })
     */
    private $client;

    /**
     * @var \Entity37\Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Entity37\Restaurant", inversedBy="reservations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rnombre", referencedColumnName="rnombre")
     * })
     */
    private $restaurant;


    /**
     * Set reservation
     *
     * @param \Entity37\Reservation $reservation
     *
     * @return ReservationRestaurant
     */
    public function setReservation(\Entity37\Reservation $reservation = null)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return \Entity37\Reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * Set client
     *
     * @param \Entity37\Client $client
     *
     * @return ReservationRestaurant
     */
    public function setClient(\Entity37\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Entity37\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set restaurant
     *
     * @param \Entity37\Restaurant $restaurant
     *
     * @return ReservationRestaurant
     */
    public function setRestaurant(\Entity37\Restaurant $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \Entity37\Restaurant
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }
}
