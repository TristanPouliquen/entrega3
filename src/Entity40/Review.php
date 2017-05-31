<?php

namespace Entity40;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="criticas", indexes={@ORM\Index(name="criticas_pkey", columns={"id"})})
 * @ORM\Entity
 */
class Review
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="critica_ai", allocationSize=100, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="nota", type="integer")
     */
    private $rating;

    /**
     * @var \Entity40\Reservation
     *
     * @ORM\OneToOne(targetEntity="Entity40\Reservation", mappedBy="review")
     */
    private $reservation;


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
     * Set description
     *
     * @param string $description
     *
     * @return Review
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Review
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set reservation
     *
     * @param \Entity40\Reservation $reservation
     *
     * @return Reservation
     */
    public function setreservation(\Entity40\Reservation $reservation = null)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return \Entity40\Reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }
}
