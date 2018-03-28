<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProvinceRepository")
 */
class Province
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $isAbolished;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Municipality", mappedBy="province")
     */
    private $municipalities;

    public function __construct()
    {
        $this->municipalities = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Province
     */
    public function setCode(string $code): Province
    {
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
     * @return Province
     */
    public function setName(string $name): Province
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAbolished(): bool
    {
        return $this->isAbolished;
    }

    /**
     * @param bool $isAbolished
     * @return Province
     */
    public function setIsAbolished(bool $isAbolished): Province
    {
        $this->isAbolished = $isAbolished;
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
     * @return Province
     */
    public function setMunicipalities($municipalities)
    {
        $this->municipalities = $municipalities;
        return $this;
    }

}
