<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Representation\Phones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;



class PhoneController extends FOSRestController
{
    /**
     * @Rest\Get("/phones", name="phone_list")
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

        $pager = $this->getDoctrine()->getRepository('App:Phone')->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

//        echo $paramFetcher->get('keyword');
//        exit();
        return new Phones($pager);
    }

    /**
     * @Rest\Get(
     *     path="/phones/{id}",
     *     name="phone_show",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode= 200
     * )
     */
    public function showAction(Phone $phone)
    {
        return $phone;
    }
}
