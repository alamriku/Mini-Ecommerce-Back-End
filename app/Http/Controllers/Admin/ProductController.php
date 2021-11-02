<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Concrete\AdminCollections;
use App\Http\Controllers\Interfaces\Collections;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use App\Http\Controllers\Interfaces\Collections as ProductCollections;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    protected $productService;
    protected $productCollection;
    public function __construct(ProductService $productService, ProductCollections $productCollection)
    {
        $this->productService = $productService;
        $this->productCollection = $productCollection;
    }

    public function index()
    {
        $products = new ProductResource($this->productCollection->products(2));
        return $this->respondWithArray(['products' => $products]);
    }

    public function store(ProductRequest $request)
    {
        if ($request->expectsJson()) {
            try {
               $this->productService->store($request->all(), $request);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->respondWithArray(['success' => true, 'message' => 'product successfully saved']);
        }
    }

    public function show(Product $product)
    {
        return $this->respondWithArray(['product' => new ProductResource($product)]);
    }

    public function update(ProductRequest $request, Product $product)
    {

        if ($request->expectsJson()) {
            try {
                $this->productService->update($request->all(), $request, $product);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->respondWithArray(['success' => true, 'message' => 'product updated successfully']);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->productService->destroy($product);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
        return $this->respondWithArray(['success' => true, 'message' => 'product deleted successfully']);
    }
}
