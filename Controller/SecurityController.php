<?php

namespace TuanQuynh\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('TuanQuynhUserBundle:Security:login.html.twig', array(
            // last username entered by the user (if any)
            'last_username' => $helper->getLastUsername(),
            // last authentication error (if any)
            'error' => $helper->getLastAuthenticationError(),
        ));
    }
    /**
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        // will never be executed
    }
    /**
     * @Route("/logout")
     */
    public function logoutAction()
    {
        // will never be executed
    }
}
