<?php


namespace App\Service;


use App\Repository\TagRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MenuGenerator
{
    private $tagRepository;
    private $urlGenerator;

    public function __construct(TagRepository $tagRepository, UrlGeneratorInterface $urlGenerator) {
        $this->tagRepository = $tagRepository;
        $this->urlGenerator = $urlGenerator;
    }

    public function generateNewsMenu(string $page): MenuElementModel
    {
        $menu = new MenuElementModel();

        $newsElement = new MenuElementModel();

        $heroesElement = $this->generateHeroesMenu($page);

        $weaponsElement = $this->generateWeaponsMenu($page);

        $newsTags = $this->tagRepository->findBy(['type' => 'news', 'category' => true], ['name' => 'ASC']);

        foreach ($newsTags as $tag) {
            $menuElement = new MenuElementModel();
            $menuElement->setTitle($tag->getName());
            $menuElement->setLink($this->urlGenerator->generate($page, ['name' => $tag->getName()]));
            $newsElement->addChild($menuElement);
        }

        $menu->addChild($newsElement);
        $menu->addChild($heroesElement);
        $menu->addChild($weaponsElement);

        return $menu;
    }

    public function generateHeroesMenu(string $page): MenuElementModel
    {
        $menu = new MenuElementModel();

        $heroesTags = $this->tagRepository->findBy(['type' => 'heroes', 'category' => true], ['name' => 'ASC']);

        foreach ($heroesTags as $tag) {
            $menuElement = new MenuElementModel();
            $menuElement->setTitle($tag->getName());
            $menuElement->setLink($this->urlGenerator->generate($page, ['name' => $tag->getName()]));
            $menu->addChild($menuElement);
        }

        return $menu;
    }

    public function generateWeaponsMenu(string $page): MenuElementModel
    {
        $menu = new MenuElementModel();

        $weaponsTags = $this->tagRepository->findBy(['type' => 'weapons', 'category' => true], ['name' => 'ASC']);

        foreach ($weaponsTags as $tag) {
            $menuElement = new MenuElementModel();
            $menuElement->setTitle($tag->getName());
            $menuElement->setLink($this->urlGenerator->generate($page, ['name' => $tag->getName()]));
            $menu->addChild($menuElement);
        }

        return $menu;
    }
}