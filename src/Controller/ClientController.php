<?php

namespace App\Controller;

use App\Entity\Client;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends FOSRestController
{
    /**
     * @Rest\Post(
     *     name="create_client",
     *     path="/api/register"
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Register client",
     * )
     * @SWG\Response(
     *     response="400",
     *     description="A violation is raised by validation",
     * )
     * @SWG\Tag(name="Register")
     *
     * @Rest\View(statusCode=201)
     * @ParamConverter("client", converter="fos_rest.request_body")
     */
    public function newClient(Client $client)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();

        return $client;
    }
}
