<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      $profile = new Profile();
      $profile->setRs('Facebook');
      $profile->setUrl('https://www.facebook.com/sofienne.azzabi');
      $manager->persist($profile);
        $profile2 = new Profile();
      $profile2->setRs('Twitter');
        $profile2->setUrl('https://www.twitter.com/sofienne.azzabi');
        $manager->persist($profile2);
        $profile3 = new Profile();
        $profile3->setRs('Linkedin');
        $profile3->setUrl('https://www.linkedin.com/sofienne.azzabi');
        $manager->persist($profile3);
        $profile4 = new Profile();
        $profile4->setRs('Github');
        $profile4->setUrl('https://www.github.com/sofienne.azzabi');
        $manager->persist($profile4);





        $manager->flush();
    }
}
