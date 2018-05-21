<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 *
 * @Hateoas\Relation(
 *     "list",
 *     href=@Hateoas\Route(
 *     "phone_list",
 *     absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *     "phone_show",
 *     parameters={ "id" = "expr(object.getId())"},
 *     absolute = true
 *     )
 * )
 *
 * @ExclusionPolicy("all")
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Expose()
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $brand;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $model;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $plateform;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $color;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $weight;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $dimensions;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $sim;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $displaySize;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $memory;

    /**
     * @ORM\Column(type="string")
     * @Expose()
     * @Serializer\Since("1.0")
     */
    private $camera;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getPlateform()
    {
        return $this->plateform;
    }

    /**
     * @param mixed $plateform
     */
    public function setPlateform($plateform): void
    {
        $this->plateform = $plateform;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * @param mixed $dimensions
     */
    public function setDimensions($dimensions): void
    {
        $this->dimensions = $dimensions;
    }

    /**
     * @return mixed
     */
    public function getSim()
    {
        return $this->sim;
    }

    /**
     * @param mixed $sim
     */
    public function setSim($sim): void
    {
        $this->sim = $sim;
    }

    /**
     * @return mixed
     */
    public function getDisplaySize()
    {
        return $this->displaySize;
    }

    /**
     * @param mixed $displaySize
     */
    public function setDisplaySize($displaySize): void
    {
        $this->displaySize = $displaySize;
    }

    /**
     * @return mixed
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param mixed $memory
     */
    public function setMemory($memory): void
    {
        $this->memory = $memory;
    }

    /**
     * @return mixed
     */
    public function getCamera()
    {
        return $this->camera;
    }

    /**
     * @param mixed $camera
     */
    public function setCamera($camera): void
    {
        $this->camera = $camera;
    }


}
