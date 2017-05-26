<?php

namespace Entity37;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuRestaurant
 *
 * @ORM\Table(name="menurestaurante", indexes={@ORM\Index(name="menurestaurante_pkey", columns={"rnombre", "plato"})})
 * @ORM\Entity
 */
class MenuRestaurant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="precio", type="integer")
     */
    private $price;

    /**
     * @var \Entity37\Restaurant
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Entity37\Restaurant", inversedBy="menuDishes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rnombre", referencedColumnName="rnombre")
     * })
     */
    private $restaurant;

    /**
     * @var \Entity37\Menu
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Entity37\Menu", inversedBy="menuPrices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plato", referencedColumnName="plato")
     * })
     */
    private $menu;


    /**
     * Set price
     *
     * @param integer $price
     *
     * @return MenuRestaurant
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
     * Set restaurant
     *
     * @param \Entity37\Restaurant $restaurant
     *
     * @return MenuRestaurant
     */
    public function setRestaurant(\Entity37\Restaurant $restaurant)
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

    /**
     * Set menu
     *
     * @param \Entity37\Menu $menu
     *
     * @return MenuRestaurant
     */
    public function setMenu(\Entity37\Menu $menu)
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
