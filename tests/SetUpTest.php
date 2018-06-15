<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 14/06/2018
 * Time: 10:31
 */

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SetUpTest extends WebTestCase
{
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
        print_r($data);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

}