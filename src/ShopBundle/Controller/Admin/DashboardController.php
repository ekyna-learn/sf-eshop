<?php

namespace ShopBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DashboardController
 * @package ShopBundle\Controller\Admin
 */
class DashboardController extends Controller
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ShopBundle:Admin/Dashboard:index.html.twig');
    }
}
