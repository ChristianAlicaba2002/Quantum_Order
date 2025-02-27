<?php

namespace App\Infrastructure\Persistence\Eloquent\Product;
use App\Models\Products;
use App\Domain\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Domain\Product\ProductRepository;

class EloquentProductRepository implements ProductRepository
{
    public function create(Product $product): void
    {
        $productModel = Products::find($product->getProductId()) ?? new Products();
        $productModel->productId = $product->getProductId();
        $productModel->productName = $product->getName();
        $productModel->category = $product->getCategory();
        $productModel->price = $product->getPrice();
        $productModel->stock = $product->getStock();
        $productModel->description = $product->getDescription(); 
        $productModel->image = $product->getImage();
        $productModel->save();
    }
    
    public function update(Product $product): void
    {
        $productModel = Products::find($product->getProductId()) ?? new Products();

        if ($productModel === null) {
            throw new \RuntimeException('Product not found');
        }

        $productModel->productId = $product->getProductId();
        $productModel->productName = $product->getName();
        $productModel->category = $product->getCategory();
        $productModel->price = $product->getPrice();
        $productModel->stock = $product->getStock();
        $productModel->description = $product->getDescription(); 
        $productModel->image = $product->getImage();
        $productModel->save();
    }

    public function findById(string $productId): ?Product
    {
        $productModel = Products::find($productId);
        if ($productModel === null) {
            return null;
        }
        return new Product(
            $productModel->id,
            $productModel->productName,
            $productModel->category,
            $productModel->price,
            $productModel->stock,
            $productModel->description,
            $productModel->image,     
        );
    }

}