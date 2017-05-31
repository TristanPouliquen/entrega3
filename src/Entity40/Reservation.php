<?php

namespace Entity40;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservas", indexes={@ORM\Index(name="reservas_pkey", columns={"id"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="reserva_ai", allocationSize=100, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="llegada", type="date")
     */
    private $arrival;

    /**
     * @var integer
     *
     * @ORM\Column(name="duracion", type="integer")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="medio_pago", type="string")
     */
    private $payment_method;

    /**
     * @var \Entity40\Review
     *
     * @ORM\OneToOne(targetEntity="Entity40\Review", inversedBy="reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="critica_id", referencedColumnName="id", unique=true, onDelete="SET NULL")
     * })
     */
    private $review;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity40\FacilityUse", mappedBy="reservation")
     */
    private $facilityUses;

    /**
     * @var \Entity40\Hotel
     *
     * @ORM\ManyToOne(targetEntity="Entity40\Hotel", inversedBy="reservations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hotel_id", referencedColumnName="id")
     * })
     */
    private $hotel;

    /**
     * @var \Entity40\Guest
     *
     * @ORM\ManyToOne(targetEntity="Entity40\Guest", inversedBy="reservations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="huesped_id", referencedColumnName="id")
     * })
     */
    private $guest;

    public function displayName() {
        return $this->getGuest()->getName() . ' the ' . $this->getArrival()->format('d/m/Y') . ' for ' . $this->getDuration() . ' days';
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->facilityUses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set arrival
     *
     * @param \DateTime $arrival
     *
     * @return Reservation
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get arrival
     *
     * @return \DateTime
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Reservation
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     *
     * @return Reservation
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->payment_method = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * Set review
     *
     * @param \Entity40\Review $review
     *
     * @return Reservation
     */
    public function setReview(\Entity40\Review $review = null)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return \Entity40\Review
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Add facilityUse
     *
     * @param \Entity40\FacilityUse $facilityUse
     *
     * @return Reservation
     */
    public function addFacilityUse(\Entity40\FacilityUse $facilityUse)
    {
        $this->facilityUses[] = $facilityUse;

        return $this;
    }

    /**
     * Remove facilityUse
     *
     * @param \Entity40\FacilityUse $facilityUse
     */
    public function removeFacilityUse(\Entity40\FacilityUse $facilityUse)
    {
        $this->facilityUses->removeElement($facilityUse);
    }

    /**
     * Get facilityUses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacilityUses()
    {
        return $this->facilityUses;
    }

    /**
     * Set hotel
     *
     * @param \Entity40\hotel $hotel
     *
     * @return Reservation
     */
    public function setHotel(\Entity40\hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \Entity40\hotel
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * Set guest
     *
     * @param \Entity40\guest $guest
     *
     * @return Reservation
     */
    public function setGuest(\Entity40\Guest $guest = null)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Get guest
     *
     * @return \Entity40\guest
     */
    public function getGuest()
    {
        return $this->guest;
    }
}
