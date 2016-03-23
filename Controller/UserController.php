<?php

namespace TuanQuynh\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends Controller
{
    /**
     * @Route("/login", name="tuanquynh_user_login", options={"expose"=true})
     * @Method({"POST"})
     */
    public function indexAction()
    {
        return $this->render('TuanQuynhUserBundle:User:login.html.twig');
    }
}
