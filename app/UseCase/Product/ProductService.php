<?php

namespace App\UseCase\Product;

use App\Infrastructure\Repositories\Product\IProductRepository;

class ProductService implements ProductUseCase
{
    protected $productRepo;

    public function __construct(IProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getProduct(string $name)
    {
        return $this->productRepo->getProduct();
    }
}
