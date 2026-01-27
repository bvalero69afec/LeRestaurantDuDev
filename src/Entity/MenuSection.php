<?php

namespace App\Entity;

use App\Repository\MenuSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuSectionRepository::class)]
#[ORM\Index(name: 'position_idx', fields: ['position'])]
class MenuSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column]
    #[Gedmo\SortablePosition]
    #[Assert\NotNull]
    private ?int $position = null;

    /**
     * @var Collection<int, MenuSectionItem>
     */
    #[ORM\OneToMany(targetEntity: MenuSectionItem::class, mappedBy: 'section', orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $menuSectionItems;

    public function __construct()
    {
        $this->menuSectionItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, MenuSectionItem>
     */
    public function getMenuSectionItems(): Collection
    {
        return $this->menuSectionItems;
    }

    public function addMenuSectionItem(MenuSectionItem $menuSectionItem): static
    {
        if (!$this->menuSectionItems->contains($menuSectionItem)) {
            $this->menuSectionItems->add($menuSectionItem);
            $menuSectionItem->setSection($this);
        }

        return $this;
    }

    public function removeMenuSectionItem(MenuSectionItem $menuSectionItem): static
    {
        if ($this->menuSectionItems->removeElement($menuSectionItem)) {
            // set the owning side to null (unless already changed)
            if ($menuSectionItem->getSection() === $this) {
                $menuSectionItem->setSection(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
