<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage", methods={"GET","POST"})
     *
     * @return array
     */
    public function indexAction(Request $request)
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('AppBundle:Video');
        $className = $repo->getClassName();
        $validator = $this->get('validator');
        $video = new $className();
        /**
         * @var Video $video
         */
//        $video->setOriginalFile($request->files->getInt(0));
//            $em->persist($video);
//        $em->flush();

        $video->setOriginalFile(new UploadedFile('/home/cold/Videos/tbbt/1.mp4','1.mp4', null, null, null, true));

        /** @var ConstraintViolation[] $errors */
        $errors = $validator->validate($video);
        return $errors[0]->getMessageTemplate();
    }
}
