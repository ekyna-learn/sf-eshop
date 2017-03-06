<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LayoutController
 * @package ShopBundle\Controller
 */
class LayoutController extends Controller
{
    /**
     * Navbar action.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function navbarAction(Request $request)
    {
        $items = [
            [
                'caption' => 'Accueil',
                'route'   => 'shop_home',
            ],
            [
                'caption' => 'Catalogue',
                'route'   => 'shop_catalog_index',
                'match'   => '~^shop_shop~',
            ],
            [
                'caption' => 'Panier',
                'route'   => 'shop_cart_index',
            ],
            [
                'caption' => 'Contact',
                'route'   => 'shop_contact',
            ],
        ];

        $activeRoute = $request->attributes->get('_route');
        foreach ($items as &$item) {
            $item['active'] = isset($item['match'])
                ? (bool)preg_match($item['match'], $activeRoute)
                : $activeRoute === $item['route'];
        }

        return $this->render('ShopBundle:Layout:navbar.html.twig', [
            'items'      => $items,
        ]);
    }
}
