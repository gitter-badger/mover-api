<?php
/**
 * Created by PhpStorm.
 * User: cold
 * Date: 8/14/15
 * Time: 7:06 AM
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOS;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as SF;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SecurityController extends Controller
{
    /**
     * @FOS\Post(path="/authenticate")
     * @FOS\RequestParam(name="usernameOrEmail")
     * @FOS\RequestParam(name="plainPassword")
     * @param string $usernameOrEmail
     * @param string $plainPassword
     * @return Array
     */
    public function authenticateAction($usernameOrEmail, $plainPassword)
    {
        $userManager = $this->get('app.user_manager');
        $translator = $this->get('translator');
        $user = $userManager->findByUsernameOrEmail($usernameOrEmail);
        if (!$user || !$userManager->isPasswordValid($user, $plainPassword)) {
            throw new BadRequestHttpException($translator->trans('exceptions.bad_password'));
        }
        return ['token' => $this->get('lexik_jwt_authentication.jwt_manager')->create($user)];
    }
}