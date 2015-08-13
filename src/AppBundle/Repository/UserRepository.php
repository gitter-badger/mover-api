<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/9/15
 * Time: 12:08 AM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository extends EntityRepository
{

    /**
     * @param $usernameOrEmail
     * @return \AppBundle\Entity\User|null
     */
    public function findByUsernameOrEmail($usernameOrEmail)
    {
        $field = filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'emailCanonical' : 'usernameCanonical';

        return $this->findOneBy([$field => strtolower($usernameOrEmail)]);
    }

//    /**
//     * @param string $username
//     * @throws UsernameNotFoundException
//     * @return \AppBundle\Entity\User
//     */
//    public function loadUserByUsername($username)
//    {
//        $user = $this->findByUsernameOrEmail($username);
//
//        if (null === $user) {
//            $message = sprintf(
//                'Unable to find an active admin AppBundle:User object identified by "%s".',
//                $username
//            );
//            throw new UsernameNotFoundException($message);
//        }
//
//        return $user;
//    }
//
//    /**
//     * Refreshes the user for the account interface.
//     *
//     * @param UserInterface|\AppBundle\Entity\User $user
//     *
//     * @throws UnsupportedUserException if the account is not supported
//     * @return \AppBundle\Entity\User|null
//     */
//    public function refreshUser(UserInterface $user)
//    {
//        $class = get_class($user);
//        if (!$this->supportsClass($class)) {
//            throw new UnsupportedUserException(
//                sprintf(
//                    'Instances of "%s" are not supported.',
//                    $class
//                )
//            );
//        }
//
//        return $this->find($user->getId());
//    }
//
//    /**
//     * Whether this provider supports the given user class.
//     *
//     * @param string $class
//     *
//     * @return bool
//     */
//    public function supportsClass($class)
//    {
//        return $this->getEntityName() === $class
//        || is_subclass_of($class, $this->getEntityName());
//    }
}