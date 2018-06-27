<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 13/06/2018
 * Time: 10:20
 */

namespace App\Tests\Controller;

use App\Entity\Phone;
use App\Tests\SetUp;

class PhoneControllerTest extends SetUp
{


    public function testPhoneListNoAuth()
    {
        $client = self::createClient();
        $client->request('GET', '/api/phones');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());

    }

    public function testPhoneListAuth()
    {

        $client = $this->createAuthenticatedClient();

        $client->request('GET', '/api/phones');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());


    }

    public function testNoAuthPhoneShow()
    {
        $client = static::createClient();

        $phone = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Phone::class)->findOneBy([]);
        $id = $phone->getId();

        $client->request('GET', '/api/phones/'.$id);

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testPhoneShowAuth()
    {
        $client = $this->createAuthenticatedClient();

        $phone = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Phone::class)->findOneBy([]);
        $id = $phone->getId();

        $client->request('GET', '/api/phones/'.$id);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPhoneShowNoExist()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', '/api/phones/500');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }







}