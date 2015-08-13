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
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\View\View;

/** @noinspection PhpInconsistentReturnPointsInspection */
class UserController extends Controller
{
    /**
     * @FOS\Get(path="/user/{id}")
     * @param User $user
     * @return User
     */
    public function getUserAction(User $user)
    {
        $this->get('app.user_manager');
        return $user;
    }

    /**
     * @FOS\Post(path="/user")
     * @SF\ParamConverter("user", converter="fos_rest.request_body", options={
     *      "deserializationContext"={"groups"={"registration"}}
     * })
     * @param User $user
     * @param ConstraintViolationListInterface $validationErrors
     * @return ConstraintViolationListInterface|null
     */
    public function createAction(User $user, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors)) {
            return View::create($validationErrors, 400);
        }
        $userManager = $this->get('app.user_manager');
        $_username = $user->getUsername();
        $_password = $user->getPlainPassword();
        $userManager->updateUser($user);
        return $this->forward('AppBundle:Default:loginCheck', [], compact('_password', '_username'));
    }

    /**
     * @FOS\Put(path="/user/{id}", requirements={"id", "\d+"})
     * @SF\ParamConverter("user", converter="fos_rest.request_body", options={"exclude" = "id"})
     *
     * @param User $user
     */
    public function updateAction(User $user)
    {

    }

    /**
     * @FOS\Get(path="/user/{usernameOrEmail}/exists")
     * @SF\ParamConverter("user", class="AppBundle:User", options={
     *      "repository_method" = "findByUsernameOrEmail",
     *      "map_method_signature" = true
     *  })
     */
    public function checkUsernameAction()
    {
    }
}