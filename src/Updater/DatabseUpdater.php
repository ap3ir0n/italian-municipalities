<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 01/04/2018
 */

namespace App\Updater;


use App\Entity\GeographicalDivision;
use App\Entity\MetropolitanCity;
use App\Entity\Municipality;
use App\Entity\Province;
use Doctrine\ORM\EntityManager;

class DatabseUpdater
{
    /**
     * @var MunicipalityRepository
     */
    private $municipalityRepository;

    /**
     * @var GeographicalDivisionRepository
     */
    private $geographicalDivisionRepository;

    /**
     * @var MetropolitanCityRepository
     */
    private $metropolitanCityRepository;

    /**
     * @var ProvinceRepository
     */
    private $provinceRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DatabseUpdater constructor.
     * @param MunicipalityRepository $municipalityRepository
     * @param GeographicalDivisionRepository $geographicalDivisionRepository
     * @param MetropolitanCityRepository $metropolitanCityRepository
     * @param ProvinceRepository $provinceRepository
     */
    public function __construct(MunicipalityRepository $municipalityRepository,
                                GeographicalDivisionRepository $geographicalDivisionRepository,
                                MetropolitanCityRepository $metropolitanCityRepository,
                                ProvinceRepository $provinceRepository,
                                EntityManager $entityManager)
    {
        $this->municipalityRepository = $municipalityRepository;
        $this->geographicalDivisionRepository = $geographicalDivisionRepository;
        $this->metropolitanCityRepository = $metropolitanCityRepository;
        $this->provinceRepository = $provinceRepository;

        $this->entityManager = $entityManager;
    }


    public function update()
    {
        $this->updateGeographicalDivisions();
        $this->updateMetropolitanCities();
        $this->updateProvinces();
        $this->updateMunicipalities();
    }

    private function updateMunicipalities() {
        $municipalities = $this->entityManager->getRepository('App:Municipality')->findAll();

        foreach ($municipalities as $municipality) {
            $updatedMunicipality = $this->municipalityRepository->findOneByCode($municipality->getIstatCode());

            if (is_null($updatedMunicipality)) {
                $municipality->setIsActive(false);
                $this->entityManager->persist($municipality);
            } else {
                $updatedMunicipality->setId($municipality->getId());
                $this->entityManager->detach($municipality);

                $updatedMunicipality->setGeographicalDivision(
                    $this->entityManager->find(
                        GeographicalDivision::class,
                        $updatedMunicipality->getGeographicalDivision()->getId()
                    )
                );

                $updatedMunicipality->setProvince(
                    $this->entityManager->find(
                        Province::class,
                        $updatedMunicipality->getProvince()->getId()
                    )
                );

                if ($updatedMunicipality->getMetropolitanCity()) {
                    $updatedMunicipality->setMetropolitanCity(
                        $this->entityManager->find(
                            MetropolitanCity::class,
                            $updatedMunicipality->getMetropolitanCity()->getId()
                        )
                    );
                }

                $updatedMunicipality = $this->entityManager->merge($updatedMunicipality);
                $this->entityManager->persist($updatedMunicipality);
            }
        }

        $istatMunicipalities = $this->municipalityRepository->findAll();

        foreach ($istatMunicipalities as $istatMunicipalitiy) {
            $databaseMunicipality = current(array_filter(
                $municipalities,
                function ($element) use ($istatMunicipalitiy) {
                    /** @var Municipality $element*/
                    return $element->getIstatCode() == $istatMunicipalitiy->getIstatCode();
            }));

            if ($databaseMunicipality === false) {
                $istatMunicipalitiy->setGeographicalDivision(
                    $this->entityManager->find(
                        GeographicalDivision::class,
                        $istatMunicipalitiy->getGeographicalDivision()->getId()
                    )
                );

                $istatMunicipalitiy->setProvince(
                    $this->entityManager->find(
                        Province::class,
                        $istatMunicipalitiy->getProvince()->getId()
                    )
                );

                if ($istatMunicipalitiy->getMetropolitanCity()) {
                    $istatMunicipalitiy->setMetropolitanCity(
                        $this->entityManager->find(
                            MetropolitanCity::class,
                            $istatMunicipalitiy->getMetropolitanCity()->getId()
                        )
                    );
                }

                $this->entityManager->persist($istatMunicipalitiy);
            }
        }

        $this->entityManager->flush();

        return;
    }

    private function updateGeographicalDivisions() {
        $geographicalDivisions = $this->entityManager->getRepository('App:GeographicalDivision')->findAll();

        foreach ($geographicalDivisions as $geographicalDivision) {
            $updatedGeographicalDivision = $this->geographicalDivisionRepository->findOneByName($geographicalDivision->getName());

            if (is_null($updatedGeographicalDivision)) {
                $geographicalDivision->setIsActive(false);
                $this->entityManager->persist($geographicalDivision);
            } else {
                $updatedGeographicalDivision->setId($geographicalDivision->getId());

                $this->entityManager->detach($geographicalDivision);
                $updatedGeographicalDivision = $this->entityManager->merge($updatedGeographicalDivision);

                $this->entityManager->persist($updatedGeographicalDivision);
            }
        }

        $this->entityManager->flush();

        $geographicalDivisions = $this->geographicalDivisionRepository->findAll();

        foreach ($geographicalDivisions as $geographicalDivision) {
            $databaseGeographicalDivision = $this->entityManager->getRepository('App:GeographicalDivision')
                ->findOneByName($geographicalDivision->getName());

            if (is_null($databaseGeographicalDivision)) {
                $this->entityManager->persist($geographicalDivision);
            }
        }

        $this->entityManager->flush();

        return;
    }

    private function updateMetropolitanCities() {
        $metropolitanCities = $this->entityManager->getRepository('App:MetropolitanCity')->findAll();

        foreach ($metropolitanCities as $metropolitanCity) {
            $updatedMetropolitanCities = $this->metropolitanCityRepository->findOneByCode($metropolitanCity->getCode());

            if (is_null($updatedMetropolitanCities)) {
                $metropolitanCity->setIsActive(false);
                $this->entityManager->persist($metropolitanCity);
            } else {
                $updatedMetropolitanCities->setId($metropolitanCity->getId());

                $this->entityManager->detach($metropolitanCity);
                $updatedMetropolitanCities = $this->entityManager->merge($updatedMetropolitanCities);
                $this->entityManager->persist($updatedMetropolitanCities);
            }
        }

        $this->entityManager->flush();

        $metropolitanCities = $this->metropolitanCityRepository->findAll();

        foreach ($metropolitanCities as $metropolitanCity) {
            $databaseMetropolitanCity = $this->entityManager->getRepository('App:MetropolitanCity')
                ->findOneByCode($metropolitanCity->getCode());

            if (is_null($databaseMetropolitanCity)) {
                $this->entityManager->persist($metropolitanCity);
            }
        }

        $this->entityManager->flush();

        return;
    }

    private function updateProvinces() {
        $provinces = $this->entityManager->getRepository('App:Province')->findAll();

        foreach ($provinces as $province) {
            $updatedProvince = $this->provinceRepository->findOneByCode($province->getCode());

            if (is_null($updatedProvince)) {
                $province->setIsActive(false);
                $this->entityManager->persist($province);
            } else {
                $updatedProvince->setId($province->getId());

                $this->entityManager->detach($province);
                $updatedProvince = $this->entityManager->merge($updatedProvince);
                $this->entityManager->persist($updatedProvince);
            }
        }

        $this->entityManager->flush();

        $provinces = $this->provinceRepository->findAll();

        foreach ($provinces as $province) {
            $databaseProvince = $this->entityManager->getRepository('App:Province')
                ->findOneByCode($province->getCode());

            if (is_null($databaseProvince)) {
                $this->entityManager->persist($province);
            }
        }

        $this->entityManager->flush();

        return;
    }
}