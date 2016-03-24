<?php

namespace TuanQuynh\UserBundle\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use TuanQuynh\UserBundle\Repository\UserRepository;
use TuanQuynh\UserBundle\Exception\UserNotFoundException;
use TuanQuynh\UserBundle\Exception\UnAuthorizedException;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var [type]
     */
    private $securityEncoder;

    /**
     * Set UserRepository.
     *
     * @param UserRepository $userRepository
     */
    public function setUserRepository(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Set SecurityEncoder.
     *
     * @param UserRepository $securityEncoder
     */
    public function setSecurityEncoder(UserPasswordEncoder $securityEncoder)
    {
        $this->securityEncoder = $securityEncoder;
    }

    /**
     * Login
     *
     * @param  string $username
     * @param  string $password
     * @return boolean
     * @throws UserNotFoundException If user not found
     * @throws UnAuthorizedException If username or password wrong
     */
    public function login($username, $password)
    {
        $user = $this->userRepository->loadUserByUsername($username);
        if (null === $user) {
            throw new UserNotFoundException(404, "User {$username} not found");
        }

        $passwordValid = $this->securityEncoder->isPasswordValid($user, $password);
        if(false === $passwordValid) {
            throw new UnAuthorizedException(401, "Username or Password wrong");
        }

        return true;
    }
}
