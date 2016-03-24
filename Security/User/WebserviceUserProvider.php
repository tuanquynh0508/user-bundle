<?php

namespace TuanQuynh\UserBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use TuanQuynh\UserBundle\Entity\User
use TuanQuynh\UserBundle\Service\UserService;

class WebserviceUserProvider implements UserProviderInterface
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * Set UserService
     *
     * @param UserService $userService
     */
    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function loadUserByUsername($username, $password)
    {
        return $this->userService->login($username, $password);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $user;
    }

    public function supportsClass($class)
    {
        return $class === 'TuanQuynh\UserBundle\Entity\User';
    }
}
