<?php
/**
 * Created by PhpStorm.
 * User: Patrick Luca Fazzi
 * Date: 28/03/2018
 */

namespace App\DataFixtures;


use App\Entity\Municipality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MunicipalityFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $piazzaArmerina = new Municipality();
        $piazzaArmerina
            ->setName('Piazza Armerina')
            ->setProvince($this->getReference(ProvinceFixtures::ENNA))
            ->setNumber(14)
            ->setGeographicalDivision($this->getReference(GeographicalDivisionFixtures::GEOGRAPHICAL_DIVISIONS['ISOLE']))
            ->setIsProvincialCapital(false)
            ->setLicensePlateCode('EN')
            ->setCadastralCode('G580');
        $manager->persist($piazzaArmerina);

        $barrafranca = new Municipality();
        $barrafranca
            ->setName('Barrafranca')
            ->setProvince($this->getReference(ProvinceFixtures::ENNA))
            ->setNumber(4)
            ->setGeographicalDivision($this->getReference(GeographicalDivisionFixtures::GEOGRAPHICAL_DIVISIONS['ISOLE']))
            ->setIsProvincialCapital(false)
            ->setLicensePlateCode('EN')
            ->setCadastralCode('A676');
        $manager->persist($barrafranca);

        $aidone = new Municipality();
        $aidone
            ->setName('Aidone')
            ->setProvince($this->getReference(ProvinceFixtures::ENNA))
            ->setNumber(2)
            ->setGeographicalDivision($this->getReference(GeographicalDivisionFixtures::GEOGRAPHICAL_DIVISIONS['ISOLE']))
            ->setIsProvincialCapital(false)
            ->setLicensePlateCode('EN')
            ->setCadastralCode('A098');
        $manager->persist($aidone);

        $manager->flush();
    }

    function getDependencies()
    {
        return [
          GeographicalDivisionFixtures::class,
          MetropolitanCityFixtures::class,
          ProvinceFixtures::class,
        ];
    }
}