<?php

namespace App\DataFixtures;

use App\Entity\AmmoType;
use App\Entity\Character;
use App\Entity\Comment;
use App\Entity\News;
use App\Entity\Skill;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Weapon;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class AppFixtures extends Fixture
{
    private $tags = [];
    private $ammoTypes = [];
    private $skills = [];
    private $users = [];
    private $news = [];

    public function load(ObjectManager $manager)
    {
        $this->loadTags($manager);
        $this->loadAmmoTypes($manager);
        $this->loadWeapons($manager);
        $this->loadSkills($manager);
        $this->loadCharacters($manager);
        $this->loadUsers($manager);
        $this->loadNews($manager);
        $this->loadComments($manager);
    }

    private function loadTags(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/TagsFixtures.yml');

        foreach ($data as $tagData) {
            $tag = new Tag();
            $tag->setName($tagData['name'])
                ->setColor($tagData['color']);

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

    private function loadWeapons(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/WeaponsFixtures.yml');

        foreach ($data as $weaponData) {
            $weapon = new Weapon();
            $weapon->setName($weaponData['name'])
                ->setDescription($weaponData['description'])
                ->setType($weaponData['type'])
                ->setImage($weaponData['image'])
                ->setBodyDamage($weaponData['bodyDamage'])
                ->setHeadDamage($weaponData['headDamage'])
                ->setRateOfFire($weaponData['rateOfFire'])
                ->setFireMode($weaponData['fireMode'])
                ->setAmmoTypeId($this->ammoTypes[$weaponData['ammoType']]);

            foreach ($weaponData['tags'] as $tag) {
                $weapon->addTag($this->tags[$tag]);
            }

            $manager->persist($weapon);
        }

        $manager->flush();
    }

    private function loadSkills(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/SkillsFixtures.yml');

        foreach ($data as $skillData) {
            $skill = new Skill();
            $skill->setName($skillData['name'])
                ->setDescription($skillData['description'])
                ->setImage($skillData['image']);

            $this->skills[$skillData['name']] = $skill;
            $manager->persist($skill);
        }

        $manager->flush();
    }

    private function loadCharacters(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/CharactersFixtures.yml');

        foreach ($data as $characterData) {
            $character = new Character();
            $character->setName($characterData['name'])
                ->setDescription($characterData['description'])
                ->setRole($characterData['role'])
                ->setImage($characterData['image']);

            foreach ($characterData['tags'] as $tag) {
                $character->addTag($this->tags[$tag]);
            }

            foreach ($characterData['skills'] as $skill) {
                $character->addSkill($this->skills[$skill]);
            }

            $manager->persist($character);
        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/UsersFixtures.yml');

        foreach ($data as $userData) {
            $user = new User();
            $user->setMail($userData['mail'])
                ->setUserName($userData['userName'])
                ->setPassword($userData['password'])
                ->setImage($userData['image']);

            $this->users[$userData['userName']] = $user;
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function loadNews(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/NewsFixtures.yml');

        foreach ($data as $newsData) {
            $news = new News();
            $news->setTitle($newsData['title'])
                ->setDate(DateTime::createFromFormat('d-m-Y',$newsData['date']))
                ->setContent($newsData['content'])
                ->setImage($newsData['image']);

            foreach ($newsData['tags'] as $tag) {
                $news->addTag($this->tags[$tag]);
            }

            $this->news[$newsData['title']] = $news;
            $manager->persist($news);
        }

        $manager->flush();
    }

    private function loadComments(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/CommentsFixtures.yml');

        foreach ($data as $commentData) {
            $comment = new Comment();
            $comment->setContent($commentData['content'])
                ->setDate(DateTime::createFromFormat('d-m-Y H:i',$commentData['date']))
                ->setUserId($this->users[$commentData['user']])
                ->setNewsId($this->news[$commentData['news']]);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
