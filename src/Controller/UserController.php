<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Handler\UserHandler;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;



class UserController extends FOSRestController
{

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Rest\Get("/api/users", name="user_list")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return users's list",
     *     @SWG\Schema(ref=@Model(type=User::class)),
     * )
     * @SWG\Response(
     *     response="401",
     *     description="JWT Token not found | JWT Token not found | Invalid JWT Token",
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Tag(name="Users")
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
                $this->tokenStorage->getToken()->getUser(),
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
     * @Rest\Get(
     *     path="api/users/{id}",
     *     name="user_show",
     *     requirements={ "id" = "\d+" }
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return the selected user",
     *     @SWG\Schema(ref=@Model(type=User::class))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="JWT Token not found | JWT Token not found | Invalid JWT Token",
     * )
     * @SWG\Response(
     *     response="404",
     *     description="Object not found or does not exist",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The user id.",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Tag(name="Users")
     *
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
     *     path="/api/users",
     *     name="user_create"
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Create user",
     * )
     * @SWG\Response(
     *     response="401",
     *     description="JWT Token not found | JWT Token not found | Invalid JWT Token",
     * )
     * @SWG\Response(
     *     response="400",
     *     description="A violation is raised by validation",
     * )
     * * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     @SWG\Schema(type="object",
     *          @SWG\Property(property="user", ref=@Model(type=User::class)))
     *)
     * @SWG\Tag(name="Users")
     *
     * @Rest\View(statusCode= 201)
     * @ParamConverter("user", converter= "fos_rest.request_body" )
     */
    public function createAction(User $user, ConstraintViolationList $validationErrors, UserHandler $handler, Request $request)
    {
        $result = $handler->create($user, $validationErrors);

        return $this->view($result, Response::HTTP_CREATED,[
            'Location'=> $this->generateUrl(
                $request->get('_route'),
                ['id' => $user->getId()]
            )
        ]);
    }


    /**
     * @Rest\Put(
     *     path="/api/users/{id}",
     *     name="user_update",
     *     requirements = { "id" = "\d+" }
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Update selected user",
     *     @SWG\Schema(ref=@Model(type=User::class))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="JWT Token not found | JWT Token not found | Invalid JWT Token",
     * )
     * @SWG\Response(
     *     response="400",
     *     description="A violation is raised by validation",
     * )
     * @SWG\Response(
     *     response="404",
     *     description="Object not found or does not exist",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The user id.",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     @SWG\Schema(type="object",
     *          @SWG\Property(property="user", ref=@Model(type=User::class)))
     *)
     * @SWG\Tag(name="Users")
     *
     * @Rest\View(statusCode=200)
     * @ParamConverter("newUser", converter="fos_rest.request_body")
     *
     */
    public function updateAction(User $user, User $newUser, ConstraintViolationList $validationErrors, UserHandler $handler)
    {
        return $handler->update($user, $newUser, $validationErrors);


        return $user;
    }

    /**
     * @Rest\Delete(
     *     path="/api/users/{id}",
     *     name="user_delete",
     *     requirements={"id" = "\d+"}
     *     )
     *
     * @SWG\Response(
     *     response=204,
     *     description="Delete selected user",
     * )
     * @SWG\Response(
     *     response="401",
     *     description="JWT Token not found | JWT Token not found | Invalid JWT Token",
     * )
     * @SWG\Response(
     *     response="400",
     *     description="A violation is raised by validation",
     * )
     *  @SWG\Response(
     *     response="404",
     *     description="Object not found or does not exist",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The user id.",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Tag(name="Users")
     *
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
