<?php

namespace Entity37;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReviewMenu
 *
 * @ORM\Table(name="criticamenu", indexes={@ORM\Index(name="criticamenu_pkey", columns={"idcritica", "plato"})})
 * @ORM\Entity
 */
class ReviewMenu
{
    /**
     * @var \Entity37\Review
     *
     * @ORM\OneToOne(targetEntity="Entity37\Review", inversedBy="menuReview")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcritica", referencedColumnName="idcritica", unique=true)
     * })
     */
    private $review;

    /**
     * @var \Entity37\Menu
     *
     * @ORM\ManyToOne(targetEntity="Entity37\Menu", inversedBy="reviews")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plato", referencedColumnName="plato")
     * })
     */
    private $menu;


    /**
     * Set review
     *
     * @param \Entity37\Review $review
     *
     * @return ReviewMenu
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
     * Set menu
     *
     * @param \Entity37\Menu $menu
     *
     * @return ReviewMenu
     */
    public function setMenu(\Entity37\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Entity37\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
