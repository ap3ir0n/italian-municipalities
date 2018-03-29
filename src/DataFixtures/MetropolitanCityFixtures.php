<?php
/**
 * Created by PhpStorm.
 * User: Patrick Luca Fazzi
 * Date: 28/03/2018
 */

namespace App\DataFixtures;


use App\Entity\MetropolitanCity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MetropolitanCityFixtures extends Fixture
{
    public const CATANIA = 'mc-catania';
    public const PALERMO = 'mc-palermo';

    public function load(ObjectManager $manager)
    {
        $catania = new MetropolitanCity('Catania', 287);
        $this->addReference(self::CATANIA, $catania);
        $manager->persist($catania);

        $palermo = new MetropolitanCity('Palermo', 282);
        $this->addReference(self::PALERMO, $catania);
        $manager->persist($palermo);

        $manager->flush();

    }
}