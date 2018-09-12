<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 09/09/2018
 * Time: 16:11
 */

namespace App\Tests\Entity;


use App\Entity\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{

    public function testNewPhone()
    {
        $phone = new Phone();
        $phone->setBrand('test');

        $this->assertEquals('test', $phone->getBrand());
        $this->assertNull($phone->getId());
    }

    public function testGettersandSetters()
    {
        $phone = new Phone();

        $arrayTest = [
            'Brand' => 'test',
            'Model' => 'test',
            'Plateform' => 'test',
            'Color' => 'test',
            'Weight' => 'test',
            'Dimensions' => 'test',
            'Sim' => 'test',
            'DisplaySize' => 'test',
            'Memory' => 'test',
            'Camera' => 'test'
        ];

        foreach ($arrayTest as $key => $value) {
            $setter = 'set'.$key;
            $getter = 'get'.$key;

            $phone->$setter($value);

            $this->assertEquals($value, $phone->$getter());
        }
    }
}