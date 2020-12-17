<?php

namespace App\DataFixtures;

use App\Entity\AmmoType;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class AppFixtures extends Fixture
{
    private $ammoTypes = [];

    public function load(ObjectManager $manager)
    {
        $this->loadAmmoTypes($manager);
    }

    private function loadAmmoTypes(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/AmmoTypesFixtures.yml');

        foreach ($data as $ammoTypeData) {
            $ammoType = new AmmoType();
            $ammoType->setName($ammoTypeData['name'])
                ->setImage($ammoTypeData['image']);

            $this->ammoTypes[$ammoTypeData['name']] = $ammoType;
            $manager->persist($ammoType);
        }

        $manager->flush();
    }
}
