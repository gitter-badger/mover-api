<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/9/15
 * Time: 2:56 AM
 */

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager
{
    private $encoderFactory;
    private $em;
    private $repository;

    /**
     * @param EncoderFactoryInterface $encoderFactory
     * @param EntityManagerInterface $em
     * @param EntityRepository|\AppBundle\Repository\UserRepository $repository
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        EntityManagerInterface $em,
        EntityRepository $repository
    ) {
        $this->encoderFactory = $encoderFactory;
        $this->em = $em;
        $this->repository = $repository;
    }

    public function findByUsernameOrEmail($usernameOrEmail)
    {
        return $this->repository->findByUsernameOrEmail($usernameOrEmail);
    }

    /**
     * @param $plainPassword
     * @param $user
     * @return bool
     */
    public function isPasswordValid(UserInterface $user, $plainPassword)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        return $encoder->isPasswordValid($user->getPassword(), $plainPassword, $user->getSalt());
    }

    /**
     * @return \AppBundle\Entity\User|UserInterface
     */
    public function createUser()
    {
        $userClass = $this->repository->getClassName();
        return new $userClass;
    }

    /**
     * @param \AppBundle\Entity\User|UserInterface $user
     * @param bool $andFlush
     * @return self
     */
    public function updateUser($user, $andFlush = true)
    {
        $this->updateCanonicalFields($user)->updatePassword($user);
        $this->em->persist($user);

        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }

    /**
     * @param \AppBundle\Entity\User|UserInterface $user
     * @param bool $andFlush
     * @return self
     */
    public function deleteUser(UserInterface $user, $andFlush = true)
    {

        $this->em->remove($user);

        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }

    /**
     * @param \AppBundle\Entity\User|UserInterface $user
     * @return self
     */
    public function updatePassword(UserInterface $user)
    {
        $plainPassword = $user->getPlainPassword();

        if ($plainPassword) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password)->eraseCredentials();
        }
        return $this;
    }

    /**
     * @param \AppBundle\Entity\User|UserInterface $user \AppBundle\Entity\User
     * @return self
     */
    public function updateCanonicalFields(UserInterface $user)
    {
        $user->setEmailCanonical(strtolower($user->getEmail()));
        $user->setUsernameCanonical(strtolower($user->getUsername()));
        return $this;
    }


}