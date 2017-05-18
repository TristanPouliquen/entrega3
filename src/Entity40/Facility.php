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
     * @ORM\SequenceGenerator(sequenceName="facilidades_id_seq", allocationSize=1, initialValue=1)
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
     * @var integer
     *
     * @ORM\Column(name="hotel_id", type="integer")
     */
    private $hotel_id;

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
}