<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Yoga",
            "Cuisisne",
            "Patisserie",
            "Photographie",
            "Blogging",
            "Lecture",
            "Apprendre une langue"
        ];
        for ($i=0;$i<count($data);$i++){
            $hobby = new Hobby();
            $hobby->setDesignation($data[$i]);
            $manager->persist($hobby);
        }
        $manager->flush();
    }
    }

