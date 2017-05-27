<?php

namespace Entity37;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 *
 * @ORM\Table(name="horario", indexes={@ORM\Index(name="horario_pkey", columns={"rnombre", "dia"})})
 * @ORM\Entity
 */
class Schedule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="dia", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $day;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="apertura", type="time without time zone")
     */
    private $opening;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cierre", type="time without time zone")
     */
    private $closing;

    /**
     * @var \Entity37\Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Entity37\Restaurant", inversedBy="schedule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rnombre", referencedColumnName="rnombre")
     * })
     */
    private $restaurant;


    /**
     * Set day
     *
     * @param integer $day
     *
     * @return Schedule
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set opening
     *
     * @param \DateTime $opening
     *
     * @return Schedule
     */
    public function setOpening($opening)
    {
        $this->opening = $opening;

        return $this;
    }

    /**
     * Get opening
     *
     * @return \DateTime
     */
    public function getOpening()
    {
        return $this->opening;
    }

    /**
     * Set closing
     *
     * @param \DateTime $closing
     *
     * @return Schedule
     */
    public function setClosing($closing)
    {
        $this->closing = $closing;

        return $this;
    }

    /**
     * Get closing
     *
     * @return \DateTime
     */
    public function getClosing()
    {
        return $this->closing;
    }

    /**
     * Set restaurant
     *
     * @param \Entity37\Restaurant $restaurant
     *
     * @return Schedule
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
