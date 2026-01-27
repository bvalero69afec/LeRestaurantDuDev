<?php

namespace App\Entity;

use App\Repository\MenuSectionItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuSectionItemRepository::class)]
#[ORM\Index(name: 'section_position_idx', fields: ['section', 'position'])]
class MenuSectionItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Assert\Length(max: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 1000, nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 1000)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotNull]
    #[Assert\Regex(
        pattern: '/\A(?:0|[1-9]\d{0,7})(?:\.\d{1,2})?\z/',
        htmlPattern: '',
        message: 'This value is not a valid number between 0 and 99999999.99.'
    )]
    private ?string $price = null;

    #[ORM\Column]
    #[Gedmo\SortablePosition]
    #[Assert\NotNull]
    private ?int $position = null;

    #[ORM\ManyToOne(inversedBy: 'menuSectionItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\SortableGroup]
    #[Assert\NotNull]
    private ?MenuSection $section = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getSection(): ?MenuSection
    {
        return $this->section;
    }

    public function setSection(?MenuSection $section): static
    {
        $this->section = $section;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
