<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GeographicalDivisionRepository")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_geographical_divisions_get",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 */
class GeographicalDivision
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Municipality", mappedBy="geographicalDivision")
     * @Serializer\Exclude()
     */
    private $municipalities;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    public function __construct(string $name = '')
    {
        $this->name = $name;
        $this->municipalities = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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
     * @return GeographicalDivision
     */
    public function setName(string $name): GeographicalDivision
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
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return GeographicalDivision
     */
    public function setIsActive(bool $isActive): GeographicalDivision
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
