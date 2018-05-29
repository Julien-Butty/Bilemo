<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Handler\UserHandler;
use Swagger\Annotations as SWG;



class UserController extends FOSRestController
{

    /**
     * @Rest\Get("/api/users", name="user_list")
     *
     *@Rest\QueryParam(
     *     name="keyword",
     *     requirements="\w+",
     *     nullable= true,
     *     description="The keyword to search for"
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|dsc",
     *     default="asc",
     *     description="Sort of order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="20",
     *     description="Max number of categories per page"
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     *
     * @Rest\View()
     *
     * @Cache(expires="+7 days", public=true)
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {

            $users = $this->getDoctrine()->getRepository('App:User')->search(
                $paramFetcher->get('keyword'),
                $paramFetcher->get('order'),
                $paramFetcher->get('limit'),
                $paramFetcher->get('offset')
            );

            $paginatedCollection = new PaginatedRepresentation(
                new CollectionRepresentation(
                    $users->getCurrentPageResults(),
                    'users',
                    'users'
                ),
                'user_list',
                array(),
                $users->getCurrentPage(),
                $users->getMaxPerPage(),
                $users->getNbPages(),
                'page',
                'limit',
                true,
                $users->getNbResults()
            );

            return $paginatedCollection;


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
     *
     * @Cache(expires="+7 days", public=true)
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


        return $this->get('app.user_handler')->create($user, $validationErrors);
    }


    /**
     * @Rest\Put(
     *     path="/api/users/{id}",
     *     name="user_update",
     *     requirements = { "id" = "\d+" }
     * )
     * @Rest\View(statusCode=200)
     * @ParamConverter("newUser", converter="fos_rest.request_body")
     *
     */
    public function updateAction(User $user, User $newUser, ConstraintViolationList $validationErrors)
    {
        return $this->get('app.user_handler')->update($user, $newUser, $validationErrors);


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
