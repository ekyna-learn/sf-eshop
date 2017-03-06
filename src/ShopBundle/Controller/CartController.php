<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
