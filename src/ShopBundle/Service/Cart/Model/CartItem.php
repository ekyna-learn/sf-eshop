<?php

namespace ShopBundle\Service\Cart\Model;

use ShopBundle\Entity\Product;

/**
 * Class CartItem
 * @package ShopBundle\Service\Cart\Model
 */
class CartItem
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;


    /**
     * Returns the product.
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Sets the product.
     *
     * @param Product $product
     *
     * @return CartItem
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Returns the quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets the quantity.
     *
     * @param int $quantity
     *
     * @return CartItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}
