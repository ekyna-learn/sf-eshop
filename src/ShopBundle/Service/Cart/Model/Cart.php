<?php

namespace ShopBundle\Service\Cart\Model;

use ShopBundle\Entity\Product;

/**
 * Class Cart
 * @package ShopBundle\Service\Cart\Model
 */
class Cart
{
    /**
     * @var array|CartItem[]
     */
    private $items;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->items = [];
    }

    /**
     * Returns whether or not the cart has the given item,
     * regarding to the item's product.
     *
     * @param CartItem $item
     *
     * @return bool
     */
    public function hasItem(CartItem $item)
    {
        return null !== $this->findItemByProduct($item->getProduct());
    }

    /**
     * Adds the item, or adds the quantity if an item
     * already exists for the same product.
     *
     * @param CartItem $item
     *
     * @return Cart
     */
    public function addItem(CartItem $item)
    {
        if (null !== $i = $this->findItemByProduct($item->getProduct())) {
            $i->setQuantity($i->getQuantity() + $item->getQuantity());
        } else {
            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * Increments the item quantity matching the given product id.
     *
     * @param int $productId
     *
     * @return bool
     */
    public function incrementQuantityByProductId($productId)
    {
        foreach ($this->items as $index => $item) {
            if ($productId == $item->getProduct()->getId()) {
                $item->setQuantity($item->getQuantity() + 1);

                return true;
            }
        }

        return false;
    }

    /**
     * Decrements the item quantity matching the given product id.
     *
     * @param int $productId
     *
     * @return bool
     */
    public function decrementQuantityByProductId($productId)
    {
        foreach ($this->items as $index => $item) {
            if ($productId == $item->getProduct()->getId()) {
                if (1 < $item->getQuantity()) {
                    $item->setQuantity($item->getQuantity() - 1);

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Removes the item matching the given product id.
     *
     * @param int $productId
     *
     * @return bool
     */
    public function removeItemByProductId($productId)
    {
        foreach ($this->items as $index => $item) {
            if ($productId == $item->getProduct()->getId()) {
                unset($this->items[$index]);

                return true;
            }
        }

        return false;
    }

    /**
     * Returns all the cart items.
     *
     * @return array|CartItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Finds the item for the given product.
     *
     * @param Product $product
     *
     * @return CartItem|null
     */
    private function findItemByProduct(Product $product)
    {
        foreach ($this->items as $item) {
            if ($product === $item->getProduct()) {
                return $item;
            }
        }

        return null;
    }
}
