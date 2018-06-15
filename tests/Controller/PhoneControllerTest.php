<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 13/06/2018
 * Time: 10:20
 */

namespace App\Tests\Controller;

use App\Tests\SetUpTest;

class PhoneControllerTest extends SetUpTest
{

    public function testListActionAuth()
    {

        $client = $this->createAuthenticatedClient();

        $client->request('GET', '/api/phones');

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertInternalType('array', $content);
    }

    public function testListActionNoAuth()
    {
        $client = self::createClient();
        $client->request('GET', '/api/phones');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());

    }

    public function testShowAction()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/phones/12');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }





}