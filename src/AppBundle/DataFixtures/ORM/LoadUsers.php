<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/17/15
 * Time: 5:18 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('app.user_manager');
        $user = $userManager->createUser();
        $user
            ->setEmail('demo@gmail.com')
            ->setUsername('demo')
            ->setPlainPassword(123456)
            ->setFirstName('Demo')
            ->setLastName('Demo')
            ->setGender(User::FEMALE)
        ;
        $userManager->updateUser($user, false);

        $admin = $userManager->createUser();
        $admin
            ->setEmail('admin@gmail.com')
            ->setUsername('admin')
            ->setPlainPassword(123456)
            ->setFirstName('Admin')
            ->setLastName('Admin')
            ->setGender(User::MALE)
            ->setRoles(User::ROLE_ADMIN)
        ;
        $userManager->updateUser($admin);
    }

    public function getOrder()
    {
        return 1;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}