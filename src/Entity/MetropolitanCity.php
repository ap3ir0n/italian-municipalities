<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetropolitanCityRepository")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_metropolitan_cities_get",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 */
class MetropolitanCity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Municipality", mappedBy="metropolitanCity")
     * @Serializer\Exclude()
     */
    private $municipalities;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * MetropolitanCity constructor.
     * @param int $code
     * @param string $name
     */
    public function __construct(string $name, int $code)
    {
        $this->setCode($code);
        $this->name = $name;
    }


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return MetropolitanCity
     */
    public function setCode(int $code): MetropolitanCity
    {
        if ($code < 1 || $code > 999) {
            throw new InvalidCodeException('The code must be between 1 an 999');
        }

        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return MetropolitanCity
     */
    public function setName(string $name): MetropolitanCity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMunicipalities()
    {
        return $this->municipalities;
    }

    /**
     * @param mixed $municipalities
     * @return MetropolitanCity
     */
    public function setMunicipalities($municipalities)
    {
        $this->municipalities = $municipalities;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return MetropolitanCity
     */
    public function setIsActive(bool $isActive): MetropolitanCity
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function __toString()
    {
        return "{$this->getName()} ({$this->getId()})";
    }
}
