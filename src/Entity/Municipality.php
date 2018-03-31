<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MunicipalityRepository")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_municipalities_get",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 */
class Municipality
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Province
     * @ORM\ManyToOne(targetEntity="App\Entity\Province", inversedBy="municipalities")
     */
    private $province;

    /**
     * @var Province
     * @ORM\ManyToOne(targetEntity="App\Entity\MetropolitanCity", inversedBy="municipalities")
     */
    private $metropolitanCity;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameInOtherLanguage;

    /**
     * @var GeographicalDivision
     * @ORM\ManyToOne(targetEntity="App\Entity\GeographicalDivision", inversedBy="municipalities")
     */
    private $geographicalDivision;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $isProvincialCapital;

    /**
     * @var string
     * @ORM\Column(type="string", length=4)
     */
    private $cadastralCode;

    /**
     * @var integer
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $legalPopulationAt2011;

    /**
     * @var string
     * @ORM\Column(type="string", length=2)
     */
    private $licensePlateCode;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Province
     */
    public function getProvince(): Province
    {
        return $this->province;
    }

    /**
     * @param Province $province
     * @return Municipality
     */
    public function setProvince(Province $province): Municipality
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Municipality
     */
    public function setNumber(int $number): Municipality
    {
        $this->number = $number;
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
     * @return Municipality
     */
    public function setName(string $name): Municipality
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameInOtherLanguage(): string
    {
        return $this->nameInOtherLanguage;
    }

    /**
     * @param string $nameInOtherLanguage
     * @return Municipality
     */
    public function setNameInOtherLanguage(string $nameInOtherLanguage): Municipality
    {
        $this->nameInOtherLanguage = $nameInOtherLanguage;
        return $this;
    }

    /**
     * @return GeographicalDivision
     */
    public function getGeographicalDivision(): GeographicalDivision
    {
        return $this->geographicalDivision;
    }

    /**
     * @param GeographicalDivision $geographicalDivision
     * @return Municipality
     */
    public function setGeographicalDivision(GeographicalDivision $geographicalDivision): Municipality
    {
        $this->geographicalDivision = $geographicalDivision;
        return $this;
    }

    /**
     * @return bool
     */
    public function isProvincialCapital(): bool
    {
        return $this->isProvincialCapital;
    }

    /**
     * @param bool $isProvincialCapital
     * @return Municipality
     */
    public function setIsProvincialCapital(bool $isProvincialCapital): Municipality
    {
        $this->isProvincialCapital = $isProvincialCapital;
        return $this;
    }

    /**
     * @return string
     */
    public function getCadastralCode(): string
    {
        return $this->cadastralCode;
    }

    /**
     * @param string $cadastralCode
     * @return Municipality
     */
    public function setCadastralCode(string $cadastralCode): Municipality
    {
        $this->cadastralCode = $cadastralCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getLegalPopulationAt2011(): int
    {
        return $this->legalPopulationAt2011;
    }

    /**
     * @param int $legalPopulationAt2011
     * @return Municipality
     */
    public function setLegalPopulationAt2011(int $legalPopulationAt2011): Municipality
    {
        $this->legalPopulationAt2011 = $legalPopulationAt2011;
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
     * @return Municipality
     */
    public function setLicensePlateCode(string $licensePlateCode): Municipality
    {
        $this->licensePlateCode = $licensePlateCode;
        return $this;
    }

    /**
     * @return Province
     */
    public function getMetropolitanCity(): Province
    {
        return $this->metropolitanCity;
    }

    /**
     * @param Province $metropolitanCity
     * @return Municipality
     */
    public function setMetropolitanCity(Province $metropolitanCity): Municipality
    {
        $this->metropolitanCity = $metropolitanCity;
        return $this;
    }

}
