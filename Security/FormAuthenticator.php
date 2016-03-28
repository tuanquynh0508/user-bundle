<?php

namespace TuanQuynh\UserBundle\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\InMemoryUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FormAuthenticator extends AbstractGuardAuthenticator
{
    private $userProvider;

    /**
   * @var \Symfony\Component\Routing\RouterInterface
   */
  private $router;

  /**
   * Default message for authentication failure.
   *
   * @var string
   */
  private $failMessage = 'Invalid credentials';

  /**
   * Creates a new instance of FormAuthenticator.
   */
  public function __construct(RouterInterface $router)
  {
      $this->router = $router;
  }

  /**
   * {@inheritdoc}
   */
  public function getCredentials(Request $request)
  {
      if ($request->getPathInfo() != '/login' || !$request->isMethod('POST')) {
          return;
      }

      return array(
      'username' => $request->request->get('username'),
      'password' => $request->request->get('password'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getUser($credentials, UserProviderInterface $userProvider)
  {
      $this->userProvider = $userProvider;
      if (!$this->userProvider instanceof InMemoryUserProvider) {
          return;
      }

      try {
          return $this->userProvider->loadUserByUsername($credentials['username']);
      } catch (UsernameNotFoundException $e) {
          throw new CustomUserMessageAuthenticationException($this->failMessage);
      }
  }

  /**
   * {@inheritdoc}
   */
  public function checkCredentials($credentials, UserInterface $user)
  {
      $login = $this->userProvider->login($credentials['username'], $credentials['password']);
      if (null !== $login) {
          return true;
      }
      throw new CustomUserMessageAuthenticationException($this->failMessage);
  }

  /**
   * {@inheritdoc}
   */
  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
  {
      $url = $this->router->generate('homepage');

      return new RedirectResponse($url);
  }

  /**
   * {@inheritdoc}
   */
  public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
  {
      $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
      $url = $this->router->generate('tuanquynh_user_login');

      return new RedirectResponse($url);
  }

  /**
   * {@inheritdoc}
   */
  public function start(Request $request, AuthenticationException $authException = null)
  {
      $url = $this->router->generate('tuanquynh_user_login');

      return new RedirectResponse($url);
  }

  /**
   * {@inheritdoc}
   */
  public function supportsRememberMe()
  {
      return false;
  }
}
