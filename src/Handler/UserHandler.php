<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 28/05/2018
 * Time: 10:23
 */

namespace App\Handler;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\ConstraintViolationList;



class UserHandler extends AbstractHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }


    public function create(User $user, ConstraintViolationList $validationErrors)
    {
        $this->validate($validationErrors);

        $user->setClient($this->tokenStorage->getToken()->getUser());
        $this->entityManager->persist($user);
        $this->entityManager->flush();


        return $user;

    }

    public function update(User $user, User $newUser, ConstraintViolationList $validationErrors)
    {
        $this->validate($validationErrors);

        $user->setFirstName($newUser->getFirstName());
        $user->setLastName($newUser->getLastName());
        $user->setMail($newUser->getMail());
        $user->setAddress($newUser->getAddress());
        $user->setPhone($newUser->getPhone());

        $this->entityManager->flush();

        return $user;

    }
}