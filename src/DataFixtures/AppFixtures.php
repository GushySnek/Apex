<?php

namespace App\DataFixtures;

use App\Entity\AmmoType;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class AppFixtures extends Fixture
{
    private $tags = [];
    private $ammoTypes = [];

    public function load(ObjectManager $manager)
    {
        $this->loadTags($manager);
        $this->loadAmmoTypes($manager);
    }

    private function loadTags(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/TagsFixtures.yml');

        foreach ($data as $tagData) {
            $tag = new Tag();
            $tag->setName($tagData['name'])
                ->setColor($tagData['color'])
                ->setType($tagData['type'])
                ->setIndividual($tagData['individual']);

            $this->tags[$tagData['name']] = $tag;
            $manager->persist($tag);
        }

        $manager->flush();
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
