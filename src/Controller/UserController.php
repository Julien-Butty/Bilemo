<?php

namespace App\Controller;

use App\Entity\User;
use App\Representation\Users;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
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
     * @Rest\Get("/api/users", name="user_list")
     *
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="\w+",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)."
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="15",
     *     description="Max number of phone per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     * @Rest\View()
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {

        $pager = $this->getDoctrine()->getRepository('App:User')->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Users($pager);
    }

    /**
     *
     * @Rest\Get(
     *     path="api/users/{id}",
     *     name="user_show",
     *     requirements={ "id" = "\d+" }
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
     * @Rest\Post(
     *     "/api/users",
     *     name="user_create"
     * )
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
     *     path="/api/users/{id}",
     *     name="user_update",
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
     *     path="/api/users/{id}",
     *     name="user_delete",
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
