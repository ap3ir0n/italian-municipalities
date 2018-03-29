<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetropolitanCityRepository")
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
     */
    private $municipalities;

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

}
