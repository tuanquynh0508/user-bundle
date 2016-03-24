<?php

namespace TuanQuynh\UserBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
use TuanQuynh\UserBundle\Entity\User;

class UserRepository extends BaseRepository implements UserLoaderInterface
{
    /**
     * Load User By Username
     *
     * @param  string $username [description]
     * @return User
     */
    public function loadUserByUsername($username)
    {
        return $this->getRepository()->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
