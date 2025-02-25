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
        $product = new Product($productId,$name,$category,$price,$stock,$description,$image);

        return $this->productRepository->create($product);
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
            $price = is_null($price) ? null : (float) $price;
            $newProduct = new Product($productId,$name,$category,$price,$stock,$description,$image);
            return $this->productRepository->update($newProduct);
        }



    public function findById(string $productId): ?Product
    {
        return $this->productRepository->findById($productId);
    }
}