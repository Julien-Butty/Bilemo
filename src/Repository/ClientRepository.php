<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 15/06/2018
 * Time: 08:35
 */

namespace App\Repository;


use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }
}