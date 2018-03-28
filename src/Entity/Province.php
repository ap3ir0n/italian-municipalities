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
     * @var string
     * @ORM\Column(type="string", length=2)
     */
    private $licensePlateCode;

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
     * @return string
     */
    public function getLicensePlateCode(): string
    {
        return $this->licensePlateCode;
    }

    /**
     * @param string $licensePlateCode
     * @return Province
     */
    public function setLicensePlateCode(string $licensePlateCode): Province
    {
        $this->licensePlateCode = $licensePlateCode;
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
