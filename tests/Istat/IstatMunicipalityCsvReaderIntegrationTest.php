<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 07/04/2018
 */

namespace App\Tests\Istat;

use App\Entity\GeographicalDivision;
use App\Entity\MetropolitanCity;
use App\Entity\Municipality;
use App\Entity\Province;
use App\Istat\CsvReader;
use PHPUnit\Framework\TestCase;

class IstatMunicipalityCsvReaderIntegrationTest extends TestCase
{
    /**
     * @var CsvReader
     */
    protected $reader;

    protected function setUp()
    {
        $fileName = __DIR__ . '\\Elenco-comuni-italiani.csv';
        $this->reader = new CsvReader($fileName);
    }

    public function testRead()
    {
        $data = $this->reader->read();

        $this->assertArrayHasKey('municipalities', $data);
        $this->assertArrayHasKey('geographicalDivisions', $data);
        $this->assertArrayHasKey('provinces', $data);
        $this->assertArrayHasKey('metropolitanCities', $data);

        $this->assertTrue(count($data['municipalities']) > 0, 'No municipalities retrieved');
        $this->assertTrue(count($data['geographicalDivisions']) > 0);
        $this->assertTrue(count($data['provinces']) > 0);
        $this->assertTrue(count($data['metropolitanCities']) > 0);

        $this->assertTrue(get_class(array_pop($data['municipalities'])) === Municipality::class);
        $this->assertTrue(get_class(array_pop($data['geographicalDivisions'])) === GeographicalDivision::class);
        $this->assertTrue(get_class(array_pop($data['provinces'])) === Province::class);
        $this->assertTrue(get_class(array_pop($data['metropolitanCities'])) === MetropolitanCity::class);
    }
}
