<?php

namespace App\Infrastructure\Repositories\Product;

interface IProductRepository
{
    public function getProduct(string $name): string;
}
