<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 14/06/2018
 * Time: 10:33
 */

namespace App\Tests\Controller;


use App\Tests\SetUpTest;

class UserControllerTest extends SetUpTest
{

    public function testListNoAuth()
    {
        $client = static::createClient();
        $client->request('GET', '/api/users');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

}