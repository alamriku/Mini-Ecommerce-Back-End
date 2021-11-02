<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Interfaces\Collections as ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    protected $productCollection;

    public function __construct(ProductCollection $productCollection)
    {
        $this->productCollection = $productCollection;
    }

    public function index()
    {
        $products = new ProductResource($this->productCollection->products(5));
        return $this->respondWithArray(['resource' => $products]);
    }

    public function show(Product $product)
    {
        return $this->respondWithArray(['product' => new ProductResource($product)]);
    }
}
