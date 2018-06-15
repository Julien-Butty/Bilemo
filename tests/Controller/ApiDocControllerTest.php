<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 14/06/2018
 * Time: 10:12
 */

namespace App\Tests\Controller;




use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiDocControllerTest extends WebTestCase
{
    public function testApiDoc()
    {
        $client = static::createClient();
        $client->request('GET', '/api/doc');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}