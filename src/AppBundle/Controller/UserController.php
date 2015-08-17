<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/9/15
 * Time: 4:54 AM
 */

namespace AppBundle\Controller;

// annotation
use Sensio\Bundle\FrameworkExtraBundle\Configuration as SF;
use FOS\RestBundle\Controller\Annotations as FOS;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\View\View;

class UserController extends Controller
{
    /**
     * @FOS\Get(path="/users/{id}", requirements={"id": "\d+"})
     * @param User $user
     * @return User
     */
    public function getUserAction(User $user)
    {
        $this->get('app.user_manager');
        return $user;
    }

    /**
     * @FOS\Get(path="user")
     */
    public function getAllUsersAction()
    {
        return $this->get('app.user_repository')->findAll();
    }

    /**
     * @FOS\Post(path="/users")
     * @SF\ParamConverter("user", converter="fos_rest.request_body", options={
     *      "deserializationContext"={"groups"={"registration"}}
     * })
     * @param User $user
     * @param ConstraintViolationListInterface $validationErrors
     * @param Request $request
     * @return null|ConstraintViolationListInterface
     */
    public function createAction(User $user, ConstraintViolationListInterface $validationErrors, Request $request)
    {
        if (count($validationErrors)) {
            return View::create($validationErrors, 400);
        }
        $this->get('app.user_manager')->updateUser($user);
        return $user;
    }

    /**
     * @FOS\Put(path="/users/{id}", requirements={"id", "\d+"})
     * @SF\ParamConverter("user", converter="fos_rest.request_body", options={"exclude" = "id"})
     *
     * @param User $user
     */
    public function updateAction(User $user)
    {

    }

    /**
     * @FOS\Get(path="/users/{usernameOrEmail}/exists")
     * @SF\ParamConverter("user", class="AppBundle:User", options={
     *      "repository_method" = "findByUsernameOrEmail",
     *      "map_method_signature" = true
     *  })
     */
    public function checkUsernameAction()
    {
    }

    /**
     * @FOS\Get(path="/users/logged-in-user")
     * @SF\Security(expression="has_role('ROLE_USER')")
     */
    function loggedInUserAction()
    {
        return $this->getUser();
    }
}