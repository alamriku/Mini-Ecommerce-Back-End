<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserOrderResource;
use App\Models\Order;
use App\Services\ProductService;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    const CREATED = 'created';
    const UPDATED = 'updated';
    protected ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $orders = new UserOrderResource(Order::with(['product','user'])->paginate(5));
        return $this->respondWithArray(['resource' => $orders]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = json_decode($request->getContent(), true);
        if($data['status'] === 'DELIVERED' && $order->status != OrderStatus::DELIVERED){
            $this->productService->updateQty($order);
        }
        $order->update(['status' => OrderStatus::getStatus($data['status'])]);
        return $this->respondWithArray(['success' => true, 'message' => 'Status updated']);
    }
}
