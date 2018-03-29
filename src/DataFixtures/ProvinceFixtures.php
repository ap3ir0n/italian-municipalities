<?php
/**
 * Created by PhpStorm.
 * User: Patrick Luca Fazzi
 * Date: 28/03/2018
 */

namespace App\DataFixtures;


use App\Entity\Province;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProvinceFixtures extends Fixture
{
    public const ENNA           = 'province-enna';
    public const CALTANISSETTA  = 'province-caltanissetta';
    public const CATANIA        = 'province-catania';

    /**
     * @param ObjectManager $manager
     * @throws \Doctrine\Common\DataFixtures\BadMethodCallException
     */
    public function load(ObjectManager $manager)
    {
        $caltanissetta = new Province('Caltanissetta', 85);
        $manager->persist($caltanissetta);
        $this->addReference(self::CALTANISSETTA, $caltanissetta);

        $enna = new Province('Enna', 86);
        $manager->persist($enna);
        $this->addReference(self::ENNA, $enna);

        $catania = new Province('Catania', 87, true);
        $manager->persist($catania);
        $this->addReference(self::CATANIA, $catania);

        $manager->flush();
    }
}