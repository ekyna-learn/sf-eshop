<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CartController
 * @package ShopBundle\Controller
 */
class CartController extends Controller
{
    /**
     * Cart index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $cart = $this->getCartProvider()->getCart();

        $total = $this
            ->get('shop.service.cart_calculator')
            ->getCartTotal();

        return $this->render('ShopBundle:Cart:index.html.twig', [
            'cart'  => $cart,
            'total' => $total,
        ]);
    }

    /**
     * Add product to cart action.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $productId = $request->attributes->get('productId');
        $quantity = $request->attributes->get('quantity');

        if ($this->getCartProvider()->add($productId, $quantity)) {
            $this->addFlash('success', 'Le produit a bien été ajouté au panier');
        } else {
            $this->addFlash('danger', 'Erreur lors de l\'ajout au panier');
        }

        // Redirige vers l'url précédente
        $referer = $request->headers->get('referer');
        if (0 < strlen($referer)) {
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('shop_catalog_index');
    }

    /**
     * Remove product form cart action.
     *
     * @param int $productId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction($productId)
    {
        if ($this->getCartProvider()->remove($productId)) {
            $this->addFlash('success', 'Le produit a bien été retiré du panier');
        } else {
            $this->addFlash('danger', 'Erreur lors du retrait du panier');
        }

        return $this->redirectToRoute('shop_cart_index');
    }

    /**
     * Decrement product quantity action.
     *
     * @param int $productId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function decrementAction($productId)
    {
        $this->getCartProvider()->decrement($productId);

        return $this->redirectToRoute('shop_cart_index');
    }

    /**
     * Increment product quantity action.
     *
     * @param int $productId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function incrementAction($productId)
    {
        $this->getCartProvider()->increment($productId);

        return $this->redirectToRoute('shop_cart_index');
    }

    /**
     * Returns the cart provider.
     *
     * @return \ShopBundle\Service\Cart\CartProvider
     */
    private function getCartProvider()
    {
        return $this->get('shop.service.cart_provider');
    }
}
