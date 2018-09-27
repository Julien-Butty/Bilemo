<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 11/09/2018
 * Time: 17:18
 */

namespace App\Tests\Handler;


use App\Entity\Client;
use App\Entity\User;
use App\Handler\UserHandler;
use App\Tests\SetUp;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Validator\ConstraintViolationList;

class UserHandlerTest extends SetUp
{
    private $client;

    public function setUp()
    {
        $this->client = $this->createAuthenticatedClient();
    }

    public function testCreate()
    {
        // Simulate http Auth
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'api';

        $user = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('App:Client')->findOneByUsername('fnak');

        $token = new UsernamePasswordToken($user, $firewallName, 'IS_AUTHENTICATED_FULLY' );
        $session->set('_security_' . $firewallName, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);

        // Mock UserHandler Constructor
        $mockEntity = $this->createMock(EntityManagerInterface::class);

        $mockToken = $this->createMock(TokenStorageInterface::class);
        $mockToken->method('getToken')->willReturn($token);


        // Mock Create() parameters
        $mockUser = new User();

        $mockValidation = $this->createMock(ConstraintViolationList::class);




        $handler = new UserHandler($mockEntity, $mockToken);

        $this->assertInstanceOf(User::class, $handler->create($mockUser, $mockValidation));

    }

}