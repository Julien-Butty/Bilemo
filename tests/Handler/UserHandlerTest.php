<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 11/09/2018
 * Time: 17:18
 */

namespace App\Tests\Handler;


use App\Entity\User;
use App\Handler\UserHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class UserHandlerTest extends TestCase
{
    public function testCreate()
    {
        $mockEntity = $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock();
        $mockToken = $this->getMockBuilder(TokenStorageInterface::class)->disableOriginalConstructor()->getMock();

        $mockConstraint = $this->getMockBuilder(ConstraintViolationList::class)->disableOriginalConstructor()->getMock();
        $mockUser = new User();

         $mockUser->setClient($mockToken->getToken()->getUser());


        $Handler = new UserHandler($mockEntity,$mockToken);

        $this->assertEquals($mockUser, $Handler->create($mockUser, $mockConstraint));



    }

}