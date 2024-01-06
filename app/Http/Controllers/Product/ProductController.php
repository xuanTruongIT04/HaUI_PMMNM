<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\UseCase\Product\ProductUseCase;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductUseCase $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()->json(['status' => 200]);
    }
}
