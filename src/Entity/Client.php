<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\UserInterface;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 *
 * @Hateoas\Relation(
 *     "register",
 *     href=@Hateoas\Route(
 *     "register",
 *     absolute=true
 * )
 * )
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Client implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose()
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @Serializer\Expose()
     *
     * @Serializer\Type("string")
     *
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose()
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="client")
     */
    private $users;


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }



    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->plainPassword,
            // see section on salt below
            // $this->salt,
        ));
    }
    /**
     * @see \Serializable::unserialize()
     * @param  [type] $serialized [description]
     * @return void
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->plainPassword,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }


}
