<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductDiscountRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductDiscount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $discount_value;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $discount_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="product_discount")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }
    

    public function getDiscountValue(): ?string
    {
        return $this->discount_value;
    }

    public function setDiscountValue(string $discount_value): self
    {
        $this->discount_value = $discount_value;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function createdAt()
    {
        $this->created_at = new \DateTime('now');
        $this->updated_at = new \DateTime('now');

    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedAt()
    {
        $this->updated_at = new \DateTime('now');

    }

    public function getDiscountName(): ?string
    {
        return $this->discount_name;
    }

    public function setDiscountName(string $discount_name): self
    {
        $this->discount_name = $discount_name;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setProductDiscount($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getProductDiscount() === $this) {
                $product->setProductDiscount(null);
            }
        }

        return $this;
    }


}
