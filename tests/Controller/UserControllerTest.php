<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 14/06/2018
 * Time: 10:33
 */

namespace App\Tests\Controller;


use App\Entity\User;
use App\Tests\SetUp;
use Symfony\Component\HttpFoundation\Response;



class UserControllerTest extends SetUp
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

    public function testShowUserNoAuth()
    {
        $client = static::createClient();

        $user =$client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('App:User')->findOneBy([]);
        $id = $user->getId();
        $client->request('GET', '/api/users/'.$id);
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testShowUserAuth()
    {
        $client = $this->createAuthenticatedClient();
        $user =$client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('App:User')->findOneBy([]);
        $id = $user->getId();
        $client->request('GET', '/api/users/'.$id);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowUserNoExist()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', '/api/users/800');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
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
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
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
        $user = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class)->findOneBy(['firstName'=>'TestPhpUnit']);
        $id = $user->getId();

        $client->request('PUT', '/api/users/'.$id, array(),array(),array('CONTENT_TYPE'=> 'application/json'), json_encode($userTest));
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateUserNoExist()
    {
        $userTest = [

            'first_name' => 'TestUpdate',
            'last_name' => 'Test',
            'mail' => 'test@mail.com',
            'address' => 'Test',
            'phone' => 'Test'

        ];

        $client = $this->createAuthenticatedClient();

        $client->request('PUT', '/api/users/800', array(),array(),array('CONTENT_TYPE'=> 'application/json'), json_encode($userTest));
        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
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
        $user = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class)->findOneBy(['firstName'=>'TestUpdate']);
        $id = $user->getId();
        $client->request('DELETE', 'api/users/'.$id,array(), array(), array('CONTENT_TYPE'=>'application/json'));
        $response = $client->getResponse();
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testDeleteNoExist()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('DELETE', 'api/users/800',array(), array(), array('CONTENT_TYPE'=>'application/json'));
        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }



}