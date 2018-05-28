<?php

namespace App\Controller;

use App\Entity\Phone;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;


class PhoneController extends FOSRestController
{
    /**
     * @Rest\Get("/api/phones", name="phone_list")
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
     *
     * @Cache(expires="+7 days", public=true)
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {

        $phones = $this->getDoctrine()->getRepository('App:Phone')->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        $paginatedCollection =  new PaginatedRepresentation(
            new CollectionRepresentation(
                $phones->getCurrentPageResults(),
                'phones',
                'phones'
            ),
            'phone_list',
            array(),
            $phones->getCurrentPage(),
            $phones->getMaxPerPage(),
            $phones->getNbPages(),
            'page',
            'limit',
            true,
            $phones->getNbResults()
        );

        return $paginatedCollection;

        return new Phones();
    }

    /**
     * @Rest\Get(
     *     path="/api/phones/{id}",
     *     name="phone_show",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode= 200
     * )
     *
     * @Cache(expires="+7 days", public=true)
     */
    public function showAction(Phone $phone)
    {
        return $phone;
    }
}
