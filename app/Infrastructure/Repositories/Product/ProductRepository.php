<?php

namespace App\Infrastructure\Repositories\Product;

class ProductRepository implements IProductRepository
{
    public function getProduct(string $name): string
    {
        return $name;
    }
}
