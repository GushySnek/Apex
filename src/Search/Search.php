<?php


namespace App\Search;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Search
{
    /**
     * @var string
     */
    private $keyword;

    /**
     * @var string[]
     */
    private $tags;

    /**
     * @var string[]
     */
    private $newsTags;

    /**
     * @var string[]
     */
    private $weaponsTags;

    /**
     * @var string[]
     */
    private $heroesTags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->newsTags = new ArrayCollection();
        $this->weaponsTags = new ArrayCollection();
        $this->heroesTags = new ArrayCollection();
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword($keyword): void
    {
        $this->keyword = $keyword;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function setTags(ArrayCollection $tags): void
    {
        $this->tags = $tags;
    }

    public function getNewsTags(): Collection
    {
        return $this->newsTags;
    }

    public function setNewsTags(ArrayCollection $newsTags): void
    {
        $this->newsTags = $newsTags;
    }

    public function getWeaponsTags(): Collection
    {
        return $this->weaponsTags;
    }

    public function setWeaponsTags(ArrayCollection $weaponsTags): void
    {
        $this->weaponsTags = $weaponsTags;
    }

    public function getHeroesTags(): Collection
    {
        return $this->heroesTags;
    }

    public function setHeroesTags(ArrayCollection $heroesTags): void
    {
        $this->heroesTags = $heroesTags;
    }
}