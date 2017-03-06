<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PageController
 * @package ShopBundle\Controller
 */
class PageController extends Controller
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ShopBundle:Page:index.html.twig');
    }

    /**
     * Contact action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction()
    {
        return $this->render('ShopBundle:Page:contact.html.twig');
    }
}
