<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 14/06/2018
 * Time: 10:33
 */

namespace App\Tests\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\SetUpTest;
use Doctrine\ORM\EntityManagerInterface;


class UserControllerTest extends SetUpTest
{


    public function testUserListNoAuth()
    {
        $client = static::createClient();
        $client->request('GET', '/api/users');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testUserListAuth()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testNoAuthUserCreation()
    {
        $userTest = [

            'first_name' => 'TestPhpUnit',
            'last_name' => 'Test',
            'mail' => 'test@mail.com',
            'address' => 'Test',
            'phone' => 'Test'

        ];

        $client = static::createClient();
        $client->request('POST', '/api/users',array(),array(),array('CONTENT_TYPE'=>'application/json'), json_encode($userTest));

        $response = $client->getResponse();
        $this->assertEquals(401, $response->getStatusCode());

    }

    public function testUserCreationAuth()
    {
        $userTest = [

            'first_name' => 'TestPhpUnit',
            'last_name' => 'Test',
            'mail' => 'test@mail.com',
            'address' => 'Test',
            'phone' => 'Test'

        ];

        $client = $this->createAuthenticatedClient();
        $client->request('POST', '/api/users',array(),array(),array('CONTENT_TYPE'=>'application/json'), json_encode($userTest));

        $response = $client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testNoAuthUserUpdate()
    {
        $userTest = [

            'first_name' => 'TestUpdate',
            'last_name' => 'Test',
            'mail' => 'test@mail.com',
            'address' => 'Test',
            'phone' => 'Test'

        ];

        $client = static::createClient();

        $client->request('PUT', '/api/users/4', array(),array(),array('CONTENT_TYPE'=> 'application/json'), json_encode($userTest));
        $response = $client->getResponse();
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testUserUpdateAuth()
    {
        $userTest = [

            'first_name' => 'TestUpdate',
            'last_name' => 'Test',
            'mail' => 'test@mail.com',
            'address' => 'Test',
            'phone' => 'Test'

        ];

        $client = $this->createAuthenticatedClient();

        $client->request('PUT', '/api/users/4', array(),array(),array('CONTENT_TYPE'=> 'application/json'), json_encode($userTest));
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNoAuthDelete()
    {
        $client = static::createClient();
        $client->request('DELETE', 'api/users/4',array(), array(), array('CONTENT_TYPE'=>'application/json'));
        $response = $client->getResponse();
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testDeleteAuth()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('DELETE', 'api/users/4',array(), array(), array('CONTENT_TYPE'=>'application/json'));
        $response = $client->getResponse();
        $this->assertEquals(204, $response->getStatusCode());
    }



}