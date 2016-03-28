<?php

namespace TuanQuynh\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
     public function loginAction(Request $request)
     {
         $authenticationUtils = $this->get('security.authentication_utils');

         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

         return $this->render(
             'TuanQuynhUserBundle:Security:login.html.twig',
             array(
                 // last username entered by the user
                 'last_username' => $lastUsername,
                 'error'         => $error,
             )
         );
     }

    /**
     * @Route("/login_check", name="check")
     */
    public function loginCheckAction()
    {}
}
