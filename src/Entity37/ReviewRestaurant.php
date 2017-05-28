<?php

namespace Entity37;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReviewRestaurant
 *
 * @ORM\Table(name="criticarestaurante", indexes={@ORM\Index(name="criticarestaurante_pkey", columns={"idcritica"})})
 * @ORM\Entity(repositoryClass="Entity37\ReviewRestaurantRepository")
 */
class ReviewRestaurant
{
    /**
     * @var \Entity37\Review
     *
     * @ORM\OneToOne(targetEntity="Entity37\Review")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcritica", referencedColumnName="idcritica", unique=true)
     * })
     */
    private $review;

    /**
     * @var \Entity37\Client
     *
     * @ORM\ManyToOne(targetEntity="Entity37\Client", inversedBy="reviews")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="telefono", referencedColumnName="telefono")
     * })
     */
    private $author;

    /**
     * @var \Entity37\Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Entity37\Restaurant", inversedBy="reviews")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rnombre", referencedColumnName="rnombre")
     * })
     */
    private $restaurant;


    /**
     * Set review
     *
     * @param \Entity37\Review $review
     *
     * @return ReviewRestaurant
     */
    public function setReview(\Entity37\Review $review = null)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return \Entity37\Review
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set author
     *
     * @param \Entity37\Client $author
     *
     * @return ReviewRestaurant
     */
    public function setAuthor(\Entity37\Client $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Entity37\Client
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set restaurant
     *
     * @param \Entity37\Restaurant $restaurant
     *
     * @return ReviewRestaurant
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
