<?php

namespace App\Application\Product;

use App\Domain\Product\Product;
use App\Domain\Product\ProductRepository;

class ProductRegister
{

    protected ProductRepository $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function create(
        string $productId,
        string $name,
        string $category,
        float $price,
        float $stock,
        string $description,    
        string $image
    )
    {
        $addProduct = new Product($productId,$name,$category,$price,$stock,$description,$image);

        return $this->productRepository->create($addProduct);
    }

    public function update(
        string $productId,
        string $name,
        string $category,
        float $price,
        float $stock,
        string $description,    
        string $image
    )
    {
        $updateProduct = new Product($productId, $name, $category, $price, $stock, $description, $image);
        return $this->productRepository->update($updateProduct);
    }

    public function findById(string $productId): ?Product
    {
        return $this->productRepository->findById($productId);
    }
}