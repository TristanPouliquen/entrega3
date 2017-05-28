<?php

namespace Entity37;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 *
 * @ORM\Table(name="restaurante", indexes={@ORM\Index(name="restaurante_pkey", columns={"rnombre"})})
 * @ORM\Entity(repositoryClass="Entity37\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @var string
     *
     * @ORM\Column(name="rnombre", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string")
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="chef", type="string")
     */
    private $chef;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacidad", type="integer")
     */
    private $capacity;

    /**
     * @var integer
     *
     * @ORM\Column(name="estrellas", type="integer")
     */
    private $star_rating;

    /**
     * @var string
     *
     * @ORM\Column(name="estilo", type="string")
     */
    private $style;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity37\MenuRestaurant", mappedBy="restaurant")
     */
    private $menuDishes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity37\Schedule", mappedBy="restaurant")
     */
    private $schedule;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity37\ReviewRestaurant", mappedBy="restaurant")
     */
    private $reviews;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity\ReservationRestaurant", mappedBy="restaurant")
     */
    private $reservations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->menuDishes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->schedule = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getAverageNote(){
        $total = 0;
        $count = 0;
        foreach($this->reviews as $review){
            $total+= $review->getReview()->getRating();
            $count++;
        }

        return round($total / $count,2);
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Restaurant
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
     * Set city
     *
     * @param string $city
     *
     * @return Restaurant
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Restaurant
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set chef
     *
     * @param string $chef
     *
     * @return Restaurant
     */
    public function setChef($chef)
    {
        $this->chef = $chef;

        return $this;
    }

    /**
     * Get chef
     *
     * @return string
     */
    public function getChef()
    {
        return $this->chef;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     *
     * @return Restaurant
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set starRating
     *
     * @param integer $starRating
     *
     * @return Restaurant
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
     * Set style
     *
     * @param string $style
     *
     * @return Restaurant
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Add menuDish
     *
     * @param \Entity37\MenuRestaurant $menuDish
     *
     * @return Restaurant
     */
    public function addMenuDish(\Entity37\MenuRestaurant $menuDish)
    {
        $this->menuDishes[] = $menuDish;

        return $this
        -> fetchOne();
    }

    /**
     * Remove menuDish
     *
     * @param \Entity37\MenuRestaurant $menuDish
     */
    public function removeMenuDish(\Entity37\MenuRestaurant $menuDish)
    {
        $this->menuDishes->removeElement($menuDish);
    }

    /**
     * Get menuDishes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuDishes()
    {
        return $this->menuDishes;
    }

    /**
     * Add schedule
     *
     * @param \Entity37\Schedule $schedule
     *
     * @return Restaurant
     */
    public function addSchedule(\Entity37\Schedule $schedule)
    {
        $this->schedule[] = $schedule;

        return $this;
    }

    /**
     * Remove schedule
     *
     * @param \Entity37\Schedule $schedule
     */
    public function removeSchedule(\Entity37\Schedule $schedule)
    {
        $this->schedule->removeElement($schedule);
    }

    /**
     * Get schedule
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Add review
     *
     * @param \Entity37\ReviewRestaurant $review
     *
     * @return Restaurant
     */
    public function addReview(\Entity37\ReviewRestaurant $review)
    {
        $this->reviews[] = $review;

        return $this;
    }

    /**
     * Remove review
     *
     * @param \Entity37\ReviewRestaurant $review
     */
    public function removeReview(\Entity37\ReviewRestaurant $review)
    {
        $this->reviews->removeElement($review);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Add reservation
     *
     * @param \Entity\ReservationRestaurant $reservation
     *
     * @return Restaurant
     */
    public function addReservation(\Entity\ReservationRestaurant $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \Entity\ReservationRestaurant $reservation
     */
    public function removeReservation(\Entity\ReservationRestaurant $reservation)
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
