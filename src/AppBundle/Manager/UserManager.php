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

class UserManager
{
    private $encoderFactory;
    private $em;
    private $repository;
    private $className;

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

    /**
     * @return \AppBundle\Entity\User
     */
    public function createUser()
    {
        $userClass = $this->repository->getClassName();
        return new $userClass;
    }

    /**
     * @param $user \AppBundle\Entity\User
     * @param bool $andFlush
     * @return $this
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
     * @param $user \AppBundle\Entity\User
     * @param bool $andFlush
     * @return $this
     */
    public function deleteUser($user, $andFlush = true)
    {

        $this->em->remove($user);

        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }

    /**
     * @param $user \AppBundle\Entity\User
     * @return $this
     */
    public function updatePassword($user)
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
     * @param $user \AppBundle\Entity\User
     * @return $this
     */
    public function updateCanonicalFields($user)
    {
        $user->setEmailCanonical(strtolower($user->getEmail()));
        $user->setUsernameCanonical(strtolower($user->getUsername()));
        return $this;
    }


}