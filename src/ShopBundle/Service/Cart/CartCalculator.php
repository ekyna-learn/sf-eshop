<?php

namespace ShopBundle\Service\Cart;

/**
 * Class CartCalculator
 * @package ShopBundle\Service\Cart
 */
class CartCalculator
{
    /**
     * @var CartProvider
     */
    private $cartProvider;

    /**
     * Constructor.
     *
     * @param CartProvider $cartProvider
     */
    public function __construct(CartProvider $cartProvider)
    {
        $this->cartProvider = $cartProvider;
    }

    /**
     * Returns the cart's total amount.
     *
     * @return float
     */
    public function getCartTotal()
    {
        $total = 0;

        $cart = $this->cartProvider->getCart();

        foreach ($cart->getItems() as $item) {
            $price = $item->getProduct()->getPrice();

            $total += $price * $item->getQuantity();
        }

        return $total;
    }
}
