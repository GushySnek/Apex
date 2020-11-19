<?php

namespace App\Entity;

use App\Repository\WeaponRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeaponRepository::class)
 */
class Weapon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="float")
     */
    private $bodyDamage;

    /**
     * @ORM\Column(type="float")
     */
    private $headDamage;

    /**
     * @ORM\Column(type="float")
     */
    private $rateOfFire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fireMode;

    /**
     * @ORM\ManyToOne(targetEntity=AmmoType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $AmmoTypeId;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class)
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBodyDamage(): ?float
    {
        return $this->bodyDamage;
    }

    public function setBodyDamage(float $bodyDamage): self
    {
        $this->bodyDamage = $bodyDamage;

        return $this;
    }

    public function getHeadDamage(): ?float
    {
        return $this->headDamage;
    }

    public function setHeadDamage(float $headDamage): self
    {
        $this->headDamage = $headDamage;

        return $this;
    }

    public function getRateOfFire(): ?float
    {
        return $this->rateOfFire;
    }

    public function setRateOfFire(float $rateOfFire): self
    {
        $this->rateOfFire = $rateOfFire;

        return $this;
    }

    public function getFireMode(): ?string
    {
        return $this->fireMode;
    }

    public function setFireMode(string $fireMode): self
    {
        $this->fireMode = $fireMode;

        return $this;
    }

    public function getAmmoTypeId(): ?AmmoType
    {
        return $this->AmmoTypeId;
    }

    public function setAmmoTypeId(?AmmoType $AmmoTypeId): self
    {
        $this->AmmoTypeId = $AmmoTypeId;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }
}
