<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GeographicalDivisionRepository")
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
     */
    private $municipalities;

    public function __construct()
    {
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

}
