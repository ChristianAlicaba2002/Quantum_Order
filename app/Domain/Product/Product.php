<?php

namespace App\Domain\Product;

class Product
{
    public function __construct(
        private string $productId,
        private string $name,
        private string $category,
        private float $price,
        private int $stock,
        private string $description,
        private string $image,
    )
    {
        $this->productId = $productId;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
        $this->description = $description;
        $this->image = $image;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getCategory(): string
    {
        return $this->category;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getStock(): int
    {
        return $this->stock;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }
    
}