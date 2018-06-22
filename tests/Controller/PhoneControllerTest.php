<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 13/06/2018
 * Time: 10:20
 */

namespace App\Tests\Controller;

use App\Entity\Phone;
use App\Tests\SetUpTest;

class PhoneControllerTest extends SetUpTest
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

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertInternalType('array', $content);
    }

//    public function testPhoneShow()
//    {
//        $phone = $this->createMock(Phone::class);
//            $phone->method('getId')
//                ->willReturn('1');
//        $this->assertSame('1', $phone->getId());
//
//        $client = $this->createAuthenticatedClient();
//        $id= $phone->getId();
//        print_r($id);
//        $client->request('GET', '/api/phones/'.$phone->getId());
////
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }







}