<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 09/09/2018
 * Time: 17:00
 */

namespace App\Tests\Entity;


use App\Entity\Client;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testNewUser()
    {
        $user = new User();
        $user->setFirstName('test');

        $this->assertEquals('test', $user->getFirstName());
        $this->assertNull($user->getId());
    }

    public function testGetterAndSetter()
    {
        $user = new User();

        $client = $this->createMock(User::class);

        $arrayTest = [
            'FirstName' => 'test',
            'LastName' => 'test',
            'Mail' => 'test',
            'Address' => 'test',
            'Phone' => 'test',
            'Client' => $client,
        ];


        foreach ( $arrayTest as $key => $value) {
            $setter = 'set' . $key;
            $getter = 'get' . $key;

            $user->$setter($value);

            $this->assertEquals($value, $user->$getter());
        }
    }


}