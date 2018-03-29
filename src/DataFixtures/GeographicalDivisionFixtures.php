<?php

namespace App\DataFixtures;


use App\Entity\GeographicalDivision;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GeographicalDivisionFixtures extends Fixture
{
    public const GEOGRAPHICAL_DIVISIONS = [
        'NORD_EST' => 'Nord-est',
        'NORD_OVEST' => 'Nord-ovest',
        'CENTRO' => 'Centro',
        'SUD' => 'Sud',
        'ISOLE' => 'Isole'
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     * @throws \Doctrine\Common\DataFixtures\BadMethodCallException
     */
    public function load(ObjectManager $manager)
    {

        foreach (self::GEOGRAPHICAL_DIVISIONS as $geographicalDivision) {
            $gd = new GeographicalDivision();
            $gd->setName($geographicalDivision);
            $manager->persist($gd);
            $this->addReference($geographicalDivision, $gd);
        }

        $manager->flush();
    }
}