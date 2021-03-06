<?php

namespace App\Entity;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @Hateoas\Relation(
 *     "list",
 *     href=@Hateoas\Route(
 *     "user_list",
 *     absolute = true
 *      )
 * )
 *
 *@Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *     "user_show",
 *     parameters={ "id" = "expr(object.getId())"},
 *     absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "create",
 *     href=@Hateoas\Route(
 *     "user_create",
 *     absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "update",
 *     href=@Hateoas\Route(
 *     "user_update",
 *     parameters={ "id" = "expr(object.getId())"},
 *     absolute = true
 *     )
 * )
 *
 *  @Hateoas\Relation(
 *     "delete",
 *     href=@Hateoas\Route(
 *     "user_delete",
 *     parameters={ "id" = "expr(object.getId())"},
 *     absolute = true
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="newUser",
 *     type="object",
 *     required={"name"}
 * )
 *
 * @ExclusionPolicy("all")
 */
class User
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
     * @Serializer\Since("1.0")
     * @Required()
     *
     * @Assert\NotBlank()
     *
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose()
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose()
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank()
     */
    private $mail;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose()
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose()
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank()
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="users")
     */
    private $client;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

}
