<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
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
    }


    /**
     * @Rest\Put(
     *     path="/users/{id}",
     *     name="users_update",
     *     requirements = { "id" = "\d+" }
     * )
     * @Rest\View(statusCode=200)
     * @ParamConverter("newUser", converter="fos_rest.request_body")
     */
    public function updateAction(User $user, User $newUser, ConstraintViolationList $validationErrors)
    {
        if (count($validationErrors)) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $user->setFirstName($newUser->getFirstName());
        $user->setLastName($newUser->getLastName());
        $user->setMail($newUser->getMail());
        $user->setAddress($newUser->getAddress());
        $user->setPhone($newUser->getPhone());

        $this->getDoctrine()->getManager()->flush();


        return $user;
    }

    /**
     * @Rest\Delete(
     *     path="users/{id}",
     *     name="users_delete",
     *     requirements={"id" = "\d+"}
     *     )
     * @Rest\View(statusCode= 204)
     */
    public function deleteAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return;
    }

}
