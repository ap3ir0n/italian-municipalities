<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 01/04/2018
 */

namespace App\Istat;


use App\Entity\GeographicalDivision;
use App\Entity\MetropolitanCity;
use App\Entity\Municipality;
use App\Entity\Province;
use Doctrine\ORM\EntityManager;

class CsvReader implements GeographicalDivisionReader, MetropolitanCityReader, MunicipalityReader, ProvinceReader
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var string
     */
    protected $rawFileContent;

    /**
     * @var array
     */
    protected $csvLines;

    /**
     * @var array
     */
    protected $municipalities;

    /**
     * @var array
     */
    protected $geographicalDivisions;

    /**
     * @var array
     */
    protected $provinces;

    /**
     * @var array
     */
    protected $metropolitanCities;

    /**
     * IstatMunicipalityCsvReader constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function read(): array
    {
        $this->readTheFileAsAnArrayOfStrings();
        $this->convertStringRowsToArrays();
        $this->buildEntities();

        return [
            'municipalities' => $this->municipalities,
            'geographicalDivisions' => $this->geographicalDivisions,
            'provinces' => $this->provinces,
            'metropolitanCities' => $this->metropolitanCities
        ];
    }

    protected function readTheFileAsAnArrayOfStrings()
    {
        $content = trim(file_get_contents($this->fileName));

        if (empty($content)) {
            throw new \RuntimeException('Error while retrieving data from ISTAT');
        }

        $this->rawFileContent = $content;

        return strlen($this->rawFileContent);
    }

    protected function convertStringRowsToArrays()
    {
        $lines = explode(PHP_EOL, $this->rawFileContent);
        $csvLines = array_map(function($line) {
            $line = utf8_encode($line);
            return str_getcsv($line, ';');
        }, $lines);

        if (empty($csvLines)) {
            throw new \RuntimeException('Error while parsing ISTAT data');
        }

        $header = array_shift($csvLines);
        $csvLines = array_map(function($line) use ($header) {
            $parsedLine = [];
            foreach ($header as $key => $value) {
                $parsedLine[$value] = $line[$key];
            }
            return $parsedLine;
        }, $csvLines);

        $this->csvLines = array_filter($csvLines, function($item) {
            return !empty($item['Denominazione in italiano']);
        });

        return \count($this->csvLines);
    }

    protected function buildEntities()
    {
        array_walk($this->csvLines, function($municipalityDataArray) {

            $metropolitanCity = $this->createOrGetMetropolitanCity($municipalityDataArray);
            $province = $this->createOrGetProvince($municipalityDataArray);

            $geographicalDivisionName = $municipalityDataArray['Ripartizione geografica'];

            if (isset($this->geographicalDivisions[$geographicalDivisionName])) {
                $geographicalDivision = $this->geographicalDivisions[$geographicalDivisionName];
            } else {
                $geographicalDivision = new GeographicalDivision($geographicalDivisionName);
                $this->geographicalDivisions[$geographicalDivisionName] = $geographicalDivision;
            }

            $municipality = new Municipality();
            $municipality
                ->setName($municipalityDataArray['Denominazione in italiano'])
                ->setGeographicalDivision($geographicalDivision)
                ->setNumber(intval($municipalityDataArray['Progressivo del Comune (2)']))
                ->setProvince($province)
                ->setLicensePlateCode($municipalityDataArray['Sigla automobilistica'])
                ->setCadastralCode($municipalityDataArray['Codice Catastale del comune'])
                ->setIsProvincialCapital(($municipalityDataArray['Flag Comune capoluogo di provincia'] == '1'))
                ->setLegalPopulationAt2011(intval($municipalityDataArray['Popolazione legale 2011 (09/10/2011)']))
                ->setNameInOtherLanguage($municipalityDataArray['Denominazione altra lingua']);

            if ($metropolitanCity) {
                $municipality->setMetropolitanCity($metropolitanCity);
            }

            $this->municipalities[$municipalityDataArray['Codice Comune formato alfanumerico']] = $municipality;


        });

        return;
    }

    /**
     * @param $municipalityData
     * @return MetropolitanCity|mixed|null
     */
    function createOrGetMetropolitanCity($municipalityData)
    {
        $metropolitanCityCode = $municipalityData['Codice Città Metropolitana'];

        if ($metropolitanCityCode === '-') {
            $metropolitanCity = null;
        } elseif (isset($this->metropolitanCities[$metropolitanCityCode])) {
            $metropolitanCity = $this->metropolitanCities[$metropolitanCityCode];
        } else {
            $metropolitanCity = new MetropolitanCity(
                $municipalityData['Denominazione Città metropolitana'], intval($metropolitanCityCode)
            );
            $this->metropolitanCities[$metropolitanCityCode] = $metropolitanCity;
        }
        return $metropolitanCity;
    }

    /**
     * @param $municipalityDataArray
     * @return Province|mixed
     */
    function createOrGetProvince($municipalityDataArray)
    {
        $provinceCode = $municipalityDataArray['Codice Provincia (1)'];

        if (isset($this->provinces[$provinceCode])) {
            $province = $this->provinces[$provinceCode];
        } else {
            $province = new Province(
                $municipalityDataArray['Denominazione provincia'], $provinceCode
            );
            if ($municipalityDataArray['Denominazione provincia'] === '-') {
                $province->setIsAbolished(true);
            }
            $this->provinces[$provinceCode] = $province;
        }
        return $province;
    }

    public function readGeographicalDivisions(): array
    {
        if (empty($this->geographicalDivisions)) {
            $this->read();
        }

        return $this->geographicalDivisions;
    }

    public function readMetropolitanCities(): array
    {
        if (empty($this->metropolitanCities)) {
            $this->read();
        }

        return $this->metropolitanCities;
    }

    public function readProvinces(): array
    {
        if (empty($this->provinces)) {
            $this->read();
        }

        return $this->provinces;
    }

    public function readMunicipalities(): array
    {
        if (empty($this->municipalities)) {
            $this->read();
        }

        return $this->municipalities;
    }


}