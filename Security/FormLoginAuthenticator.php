<?php

namespace TuanQuynh\UserBundle\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != '/login_check') {
            return;
        }
        $username = $request->request->get('_username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('_password');

        return array(
            'username' => $username,
            'password' => $password,
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $userProvider->loadUserByUsername($credentials['username']);
        if (null !== $user) {
            return $user;
        }
        throw new CustomUserMessageAuthenticationException($this->failMessage);

    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $webserviceUserProvider = $this->container->get('tuan_quynh_user.security.webservice_user_provider');

        try {
            $user = $webserviceUserProvider->login($credentials['username'], $credentials['password']);

            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // AJAX! Maybe return some JSON
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(
                // you could translate the message
                array('message' => $exception->getMessageKey()),
                403
            );
        }
        // for non-AJAX requests, return the normal redirect
        return parent::onAuthenticationFailure($request, $exception);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // AJAX! Return some JSON
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(
                // maybe send back the user's id
                array('userId' => $token->getUser()->getId())
            );
        }
        // for non-AJAX requests, return the normal redirect
        return parent::onAuthenticationSuccess($request, $token, $providerKey);
    }

    protected function getLoginUrl()
    {
        return $this->container->get('router')
            ->generate('security_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->container->get('router')
            ->generate('homepage');
    }
}
