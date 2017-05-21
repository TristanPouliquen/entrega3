<?php

namespace Entity40;

use Doctrine\ORM\Mapping as ORM;

/**
 * Guest
 *
 * @ORM\Table(name="huespedes", indexes={@ORM\Index(name="huespedes_pkey", columns={"id"})})
 * @ORM\Entity
 */
class Guest
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="huesped_ai", allocationSize=100, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_telefono", type="string")
     */
    private $phone_number;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacion", type="string")
     */
    private $identity_number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date")
     */
    private $birthdate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity40\reservation", mappedBy="huesped_id", cascade={"persist","merge"})
     */
    private $reservations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Guest
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Guest
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Set identityNumber
     *
     * @param string $identityNumber
     *
     * @return Guest
     */
    public function setIdentityNumber($identityNumber)
    {
        $this->identity_number = $identityNumber;

        return $this;
    }

    /**
     * Get identityNumber
     *
     * @return string
     */
    public function getIdentityNumber()
    {
        return $this->identity_number;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Guest
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Add reservation
     *
     * @param \Entity40\reservation $reservation
     *
     * @return Guest
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
