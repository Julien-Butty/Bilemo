<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 14/06/2018
 * Time: 10:31
 */

namespace App\Tests;


use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SetUp extends WebTestCase
{

    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

//    public function logIn()
//    {
//        $session = $this->client->getContainer()->get('session');
//
//        $client = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('App:Client')->findOneBy([]);
//        $username = $client->getUsername();
//        $password = $client->getPassword();
//        var_dump($password);
//
//        $firewallName = 'main';
//
//
//        $token = new UsernamePasswordToken($username, '', $firewallName, array('ROLE_ADMIN'));
//        $session->set('_security_'.$firewallName,serialize($token));
//        $session->save();
//
//        $cookie = new Cookie($session->getName(), $session->getId());
//        $this->client->getCookieJar()->set($cookie);
//    }

    /**
     * @param string $username
     * @param string $password
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'fnak', $password = '123456')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            array(
                '_username' => $username,
                '_password' => $password,
            )
        );
        $data = json_decode($client->getResponse()->getContent(), true);


        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

}