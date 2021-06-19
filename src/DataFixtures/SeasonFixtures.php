<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        'Season 1',
        'Season 2',
        'Season 3',
        'Season 4',
        'Season 5',
        
        
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SEASONS as $key => $SeasonNumber) { 
            $season = new Season();     
            $season->setNumber($key+1);    
            $season->setYear($key+1);    
            $season->setDescription("description $key");    
            $season->setProgram($this->getReference('program_1'));   
            $manager->persist($season);
            $this->addReference('season_' . $key, $season);
        }  
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          ProgramFixtures::class,
        ];
    }
}