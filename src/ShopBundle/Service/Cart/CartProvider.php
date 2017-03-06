<?php

namespace ShopBundle\Service\Cart;

use ShopBundle\Service\Cart\Model\Cart;
use ShopBundle\Service\Cart\Model\CartItem;
use ShopBundle\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CartProvider\Cart
 * @package ShopBundle\Service
 */
class CartProvider
{
    const SESSION_CART_KEY = 'cart';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var Cart
     */
    private $cart;


    /**
     * Constructor.
     *
     * @param SessionInterface $session
     * @param ProductRepository $productRepository
     */
    public function __construct(
        SessionInterface $session,
        ProductRepository $productRepository
    ) {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    /**
     * Returns the cart.
     *
     * @return Cart
     */
    public function getCart()
    {
        $this->loadCart();

        return $this->cart;
    }

    /**
     * Adds the product to the cart.
     *
     * @param int $productId
     * @param int $quantity
     *
     * @return bool Whether it succeed or not.
     */
    public function add($productId, $quantity)
    {
        $this->loadCart();

        if (null !== $product = $this->findProductById($productId)) {
            $item = new CartItem();
            $item
                ->setProduct($product)
                ->setQuantity($quantity);

            $this->cart->addItem($item);

            $this->saveCart();

            return true;
        }

        return false;
    }

    /**
     * Decrements the quantity for the given product id.
     *
     * @param int $productId
     *
     * @return bool
     */
    public function decrement($productId)
    {
        $this->loadCart();

        $success = $this->cart->decrementQuantityByProductId($productId);

        $this->saveCart();

        return $success;
    }

    /**
     * Increments the quantity for the given product id.
     *
     * @param int $productId
     *
     * @return bool
     */
    public function increment($productId)
    {
        $this->loadCart();

        $success = $this->cart->incrementQuantityByProductId($productId);

        $this->saveCart();

        return $success;
    }

    /**
     * Removes the item for the given product id.
     *
     * @param int $productId
     *
     * @return bool
     */
    public function remove($productId)
    {
        $this->loadCart();

        $success = $this->cart->removeItemByProductId($productId);

        $this->saveCart();

        return $success;
    }

    /**
     * Saves the cart.
     */
    public function saveCart()
    {
        $this->loadCart();

        $data = [];

        foreach ($this->cart->getItems() as $item) {
            $data[$item->getProduct()->getId()] = $item->getQuantity();
        }

        $this->session->set(static::SESSION_CART_KEY, $data);
    }

    /**
     * Loads the cart from the session.
     */
    private function loadCart()
    {
        // Abort if already loaded
        if (null !== $this->cart) {
            return;
        }

        $this->cart = new Cart();

        // Get the cart data from the session
        $data = $this->session->get(static::SESSION_CART_KEY, []);

        // If data is not empty, a cart has been previously saved
        if (!empty($data)) {
            foreach ($data as $productId => $quantity) {
                /** @var \ShopBundle\Entity\Product $product */
                if (null !== $product = $this->productRepository->find($productId)) {
                    // Product has been found, create the cart item
                    $item = new CartItem();
                    $item
                        ->setProduct($product)
                        ->setQuantity($quantity);

                    $this->cart->addItem($item);
                }
            }
        }
    }

    /**
     * Finds a product by its id.
     *
     * @param int $productId
     *
     * @return null|\ShopBundle\Entity\Product
     */
    private function findProductById($productId)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->productRepository->find($productId);
    }
}
