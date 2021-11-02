<?php

namespace App\Http\Controllers\Website;

use App\Enums\OrderStatus;
use App\Events\OrderActionEvent;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\UserOrderCollection;
use App\Http\Resources\UserOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class OrderController extends ApiController
{
    const CREATED = 'created';
    const UPDATED = 'updated';
    const DELETED = 'deleted';

    public function index()
    {
        $orders = new UserOrderResource(auth()->user()->orders()->with(['product'])->paginate(5));
        return $this->respondWithArray(['resource' => $orders]);
    }

    public function store(OrderRequest $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
            $order = Order::create([
                'external_id' => Uuid::uuid4()->toString(),
                'user_id' => $data['userId'],
                'product_id' => $data['productId'],
                'purchase_price' => $data['purchasePrice'],
                'qty' => $data['qty'],
                'status' => OrderStatus::PENDING,

            ]);
            event(new OrderActionEvent($order, self::CREATED));
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
        return $this->respondWithArray(['success' => true, 'message' => 'Congrats Order Completed.']);
    }
}
