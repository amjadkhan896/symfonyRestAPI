<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductDiscount", inversedBy="products")
     */
    private $product_discount;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pgroup", mappedBy="group_products")
     */
    private $products_group;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderDetails", mappedBy="product")
     */
    private $product_order;



    public function __construct()
    {
        $this->products_group = new ArrayCollection();
        $this->product_order = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProductDiscount(): ?ProductDiscount
    {
        return $this->product_discount;
    }

    public function setProductDiscount(?ProductDiscount $product_discount): self
    {
        $this->product_discount = $product_discount;

        return $this;
    }

    /**
     * @return Collection|Pgroup[]
     */
    public function getProductsGroup(): Collection
    {
        return $this->products_group;
    }

    public function addProductsGroup(Pgroup $productsGroup): self
    {
        if (!$this->products_group->contains($productsGroup)) {
            $this->products_group[] = $productsGroup;
            $productsGroup->addGroupProduct($this);
        }

        return $this;
    }

    public function removeProductsGroup(Pgroup $productsGroup): self
    {
        if ($this->products_group->contains($productsGroup)) {
            $this->products_group->removeElement($productsGroup);
            $productsGroup->removeGroupProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|OrderDetails[]
     */
    public function getProductOrder(): Collection
    {
        return $this->product_order;
    }

    public function addProductOrder(OrderDetails $productOrder): self
    {
        if (!$this->product_order->contains($productOrder)) {
            $this->product_order[] = $productOrder;
            $productOrder->setProduct($this);
        }

        return $this;
    }

    public function removeProductOrder(OrderDetails $productOrder): self
    {
        if ($this->product_order->contains($productOrder)) {
            $this->product_order->removeElement($productOrder);
            // set the owning side to null (unless already changed)
            if ($productOrder->getProduct() === $this) {
                $productOrder->setProduct(null);
            }
        }

        return $this;
    }



}
