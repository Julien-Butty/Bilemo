<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 09/09/2018
 * Time: 17:38
 */

namespace App\Tests\Entity;


use App\Entity\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testNewClient()
    {
        $client = new Client();

        $client->setUsername('test');

        $this->assertEquals('test', $client->getUsername());
        $this->assertNull($client->getId());
    }

    public function testSetterAndGetter()
    {
        $client = new Client();

        $arrayTest = [
            'Username' => 'test',
            'Password' => 'test',
            'Email' => 'test',
            'PlainPassword' => 'test'
        ];

        foreach ($arrayTest as $key => $value) {
            $setter = 'set' . $key;
            $getter = 'get' . $key;

            $client->$setter($value);
            $this->assertEquals($value, $client->$getter());
        }

    }
}