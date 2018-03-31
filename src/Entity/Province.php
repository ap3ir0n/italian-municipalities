<?php

namespace App\Entity;

use App\Exceptions\InvalidCodeException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProvinceRepository")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_provinces_get",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 */
class Province
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer
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
     * @Serializer\Exclude()
     */
    private $municipalities;

    /**
     * Province constructor.
     * @param int $code
     * @param string $name
     * @param bool $isAbolished
     *
     * @throws InvalidCodeException
     */
    public function __construct(string $name, int $code, bool $isAbolished = false)
    {
        $this->setCode($code);
        $this->name = $name;
        $this->isAbolished = $isAbolished;
        $this->municipalities = new ArrayCollection();
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
     * @return Province
     * @throws InvalidCodeException
     */
    public function setCode(int $code): Province
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

}
