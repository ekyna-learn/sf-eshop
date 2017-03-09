<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SecurityController
 * @package ShopBundle\Controller
 */
class SecurityController extends Controller
{
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // Erreur d'authentification (peut être null).
        $error = $authenticationUtils->getLastAuthenticationError();

        // Denier nom d'utilisateur saisi.
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('ShopBundle:Security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}
