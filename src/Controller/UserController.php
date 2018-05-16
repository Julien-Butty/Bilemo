<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class UserController extends FOSRestController
{

    /**
     * @Rest\Get("/users", name="user_list")
     * @Rest\View()
     */
    public function listAction()
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findAll();
        $data = $this->get('jms_serializer')->serialize($user, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Get(
     *     path="/users/{id}",
     *     name="user_show",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode= 200
     * )
     */
    public function showAction(User $user)
    {
        return $user;
    }

    /**
     * @Rest\Post("/users")
     * @Rest\View(statusCode= 201)
     * @ParamConverter("user", converter= "fos_rest.request_body" )
     */
    public function createAction(User $user, ConstraintViolationList $validationErrors)
    {
        if (count($validationErrors)) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
//        return $this->view($user, Response::HTTP_CREATED, ['Location' => $this->generateUrl(
//            'user_show', ['id' => $user->getId()], UrlGeneratorInterface::ABSOLUTE_URL
//        )]);

    }

}
