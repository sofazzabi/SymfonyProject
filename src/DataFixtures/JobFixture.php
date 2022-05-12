<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Datascientist",
            "Statisticien",
            "Médecin Orl",
            "Mathématicien",
            "Ingénieur logiciel",
            "Analyste informatique",
            "échographise",
            "Hygiéniste dentaire"

        ];
for ($i=0;$i<count($data);$i++){
        $job = new Job();
        $job->setDesignation($data[$i]);
         $manager->persist($job);
}
        $manager->flush();
    }
}
