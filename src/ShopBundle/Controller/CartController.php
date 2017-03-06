<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return $this->render('ShopBundle:Cart:index.html.twig');
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

        return new Response('Product id: ' . $productId . '<br>Quantity: ' . $quantity);
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
        return new Response('Product id: ' . $productId);
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
        return new Response('Product id: ' . $productId);
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
        return new Response('Product id: ' . $productId);
    }
}
