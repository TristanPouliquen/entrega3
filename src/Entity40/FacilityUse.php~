<?php

namespace Entity40;

use Doctrine\ORM\Mapping as ORM;

/**
 * FacilityUse
 *
 * @ORM\Table(name="usos", indexes={@ORM\Index(name="usos_pkey", columns={"id"})})
 * @ORM\Entity
 */
class FacilityUse
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="uso_ai", allocationSize=100, initialValue=1)
     */
    private $id;

    /**
     * @var \Entity40\Facility
     *
     * @ORM\ManyToOne(targetEntity="Entity40\Facility", inversedBy="facilityUses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     * })
     */
    private $facility;

    /**
     * @var \Entity40\reservation
     *
     * @ORM\ManyToOne(targetEntity="Entity40\reservation", inversedBy="facilityUses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reservation_id", referencedColumnName="id")
     * })
     */
    private $reservation;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return FacilityUse
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set facility
     *
     * @param \Entity40\Facility $facility
     *
     * @return FacilityUse
     */
    public function setFacility(\Entity40\Facility $facility = null)
    {
        $this->facility = $facility;

        return $this;
    }

    /**
     * Get facility
     *
     * @return \Entity40\Facility
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * Set reservation
     *
     * @param \Entity40\reservation $reservation
     *
     * @return FacilityUse
     */
    public function setReservation(\Entity40\reservation $reservation = null)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return \Entity40\reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }
}
