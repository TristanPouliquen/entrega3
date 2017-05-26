<?php

namespace Entity37;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menu", indexes={@ORM\Index(name="menu_pkey", columns={"plato"})})
 * @ORM\Entity
 */
class Menu
{
    /**
     * @var string
     *
     * @ORM\Column(name="plato", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $dish_name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="vegan", type="boolean")
     */
    private $vegan;

    /**
     * @var boolean
     *
     * @ORM\Column(name="veggie", type="boolean")
     */
    private $veggie;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Entity37\MenuRestaurant", mappedBy="menu")
     */
    private $menuPrices;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->menuPrices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set dishName
     *
     * @param string $dishName
     *
     * @return Menu
     */
    public function setDishName($dishName)
    {
        $this->dish_name = $dishName;

        return $this;
    }

    /**
     * Get dishName
     *
     * @return string
     */
    public function getDishName()
    {
        return $this->dish_name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Menu
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
     * Set vegan
     *
     * @param boolean $vegan
     *
     * @return Menu
     */
    public function setVegan($vegan)
    {
        $this->vegan = $vegan;

        return $this;
    }

    /**
     * Get vegan
     *
     * @return boolean
     */
    public function getVegan()
    {
        return $this->vegan;
    }

    /**
     * Set veggie
     *
     * @param boolean $veggie
     *
     * @return Menu
     */
    public function setVeggie($veggie)
    {
        $this->veggie = $veggie;

        return $this;
    }

    /**
     * Get veggie
     *
     * @return boolean
     */
    public function getVeggie()
    {
        return $this->veggie;
    }

    /**
     * Add menuPrice
     *
     * @param \Entity37\MenuRestaurant $menuPrice
     *
     * @return Menu
     */
    public function addMenuPrice(\Entity37\MenuRestaurant $menuPrice)
    {
        $this->menuPrices[] = $menuPrice;

        return $this;
    }

    /**
     * Remove menuPrice
     *
     * @param \Entity37\MenuRestaurant $menuPrice
     */
    public function removeMenuPrice(\Entity37\MenuRestaurant $menuPrice)
    {
        $this->menuPrices->removeElement($menuPrice);
    }

    /**
     * Get menuPrices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuPrices()
    {
        return $this->menuPrices;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $reviews;


    /**
     * Add review
     *
     * @param \Entity37\ReviewMenu $review
     *
     * @return Menu
     */
    public function addReview(\Entity37\ReviewMenu $review)
    {
        $this->reviews[] = $review;

        return $this;
    }

    /**
     * Remove review
     *
     * @param \Entity37\ReviewMenu $review
     */
    public function removeReview(\Entity37\ReviewMenu $review)
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
}
