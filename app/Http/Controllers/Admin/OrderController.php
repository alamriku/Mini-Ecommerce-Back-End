<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    const CREATED = 'created';
    const UPDATED = 'updated';

    public function index()
    {
        $orders = new UserOrderResource(Order::with(['product','user'])->paginate(5));
        return $this->respondWithArray(['resource' => $orders]);
    }
}
