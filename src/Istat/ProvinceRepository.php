<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 07/04/2018
 */

namespace App\Istat;


use App\Entity\Province;

class ProvinceRepository implements \App\Updater\ProvinceRepository
{
    /**
     * @var ProvinceReader
     */
    private $reader;

    /**
     * @var array
     */
    private $provinces;

    /**
     * ProvinceRepository constructor.
     * @param ProvinceReader $reader
     */
    public function __construct(ProvinceReader $reader)
    {
        $this->reader = $reader;
        $this->provinces = [];
    }

    public function findAll(): array
    {
        return $this->getProvinces();
    }

    public function findOneByCode($code): ?Province
    {
        $provinces = $this->getProvinces();

        if (!isset($provinces[$code])) {
            return null;
        }

        return $provinces[$code];
    }

    /**
     * @return array
     */
    private function getProvinces(): array
    {
        if (empty($this->provinces)) {
            $provinces = $this->reader->readProvinces();
            foreach ($provinces as $province) {
                /** @var Province $province */
                $this->provinces[$province->getCode()] = $province;
            }
        }

        return $this->provinces;
    }
}