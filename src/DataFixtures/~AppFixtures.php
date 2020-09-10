<?php

namespace App\DataFixtures;

use App\Entity\Skills;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $skill = new Skills();
        $skill->setNom('html');
        $skill->setFramework('Symfony');
        $skill->setCms('Wordpress');
        $manager->persist($skill);

        $manager->flush();
    }
}
