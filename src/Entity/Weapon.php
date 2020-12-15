<?php

namespace App\Entity;

use App\Repository\WeaponRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class)
     * @ORM\JoinColumn(nullable=false)
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
    private $ammoType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tag;

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

    public function getType(): ?Tag
    {
        return $this->type;
    }

    public function setType(?Tag $type): self
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

    public function getAmmoType(): ?AmmoType
    {
        return $this->ammoType;
    }

    public function setAmmoType(?AmmoType $ammoType): self
    {
        $this->ammoType = $ammoType;

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
