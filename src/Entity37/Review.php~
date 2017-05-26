<?php

namespace Entity37;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="critica", indexes={@ORM\Index(name="critica_pkey", columns={"idcritica"})})
 * @ORM\Entity
 */
class Review
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idcritica", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="critica_idcritica_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="descripción", type="string")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="nota", type="integer")
     */
    private $rating;

    /**
     * @var \Entity37\ReviewMenu
     *
     * @ORM\OneToOne(targetEntity="Entity37\ReviewMenu", mappedBy="review")
     */
    private $menuReview;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Review
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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
     * Set menuReview
     *
     * @param \Entity37\ReviewMenu $menuReview
     *
     * @return Review
     */
    public function setMenuReview(\Entity37\ReviewMenu $menuReview = null)
    {
        $this->menuReview = $menuReview;

        return $this;
    }

    /**
     * Get menuReview
     *
     * @return \Entity37\ReviewMenu
     */
    public function getMenuReview()
    {
        return $this->menuReview;
    }
}
