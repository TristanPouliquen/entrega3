<?php

namespace Entity40;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facility
 *
 * @ORM\Table(name="facilidades", indexes={@ORM\Index(name="facilidades_pkey", columns={"id"})})
 * @ORM\Entity
 */
class Facility
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="facilidad_ai", allocationSize=100, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="precio", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string")
     */
    private $type;

    /**
     * @var \Entity40\Hotel
     *
     * @ORM\ManyToOne(targetEntity="Entity40\Hotel", inversedBy="facilities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hotel_id", referencedColumnName="id")
     * })
     */
    private $hotel;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity40\facilityUses", mappedBy="facility", cascade={"persist"})
     */
    private $facilityUses;

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
     * Set price
     *
     * @param integer $price
     *
     * @return Facility
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Facility
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set hotelId
     *
     * @param integer $hotelId
     *
     * @return Facility
     */
    public function setHotelId($hotelId)
    {
        $this->hotel_id = $hotelId;

        return $this;
    }

    /**
     * Get hotelId
     *
     * @return integer
     */
    public function getHotelId()
    {
        return $this->hotel_id;
    }

    /**
     * Add facilityUse
     *
     * @param \Entity40\facilityUses $facilityUse
     *
     * @return Facility
     */
    public function addFacilityUse(\Entity40\facilityUses $facilityUse)
    {
        $this->facilityUses[] = $facilityUse;

        return $this;
    }

    /**
     * Remove facilityUse
     *
     * @param \Entity40\facilityUses $facilityUse
     */
    public function removeFacilityUse(\Entity40\facilityUses $facilityUse)
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
     * @param \Entity40\Hotel $hotel
     *
     * @return Facility
     */
    public function setHotel(\Entity40\Hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \Entity40\Hotel
     */
    public function getHotel()
    {
        return $this->hotel;
    }
}
