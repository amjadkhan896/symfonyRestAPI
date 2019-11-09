<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PgroupRepository")
 */
class Pgroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="products_group")
     */
    private $group_products;

    public function __construct()
    {
        $this->group_products = new ArrayCollection();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getGroupProducts(): Collection
    {
        return $this->group_products;
    }

    public function addGroupProduct(Product $groupProduct): self
    {
        if (!$this->group_products->contains($groupProduct)) {
            $this->group_products[] = $groupProduct;
        }

        return $this;
    }

    public function removeGroupProduct(Product $groupProduct): self
    {
        if ($this->group_products->contains($groupProduct)) {
            $this->group_products->removeElement($groupProduct);
        }

        return $this;
    }
}
