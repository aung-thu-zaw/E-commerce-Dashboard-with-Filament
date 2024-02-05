<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatedOrderRequest;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class CustomerOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:orders.view', ['only' => ['index']]);
        $this->middleware('permission:orders.edit', ['only' => ['show','update']]);
    }

    public function index(): JsonResponse
    {
        try {
            $orders = Order::search(request('search'))
                ->query(function (Builder $builder) {
                    $builder->with(['user:id,name'])
                        ->filterBy(request(['status', 'category']));
                })
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($orders, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(Order $order): JsonResponse
    {
        try {
            $order->load(['orderItems.product.addons']);
            return response()->json($order, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(UpdatedOrderRequest $request, Order $order): JsonResponse
    {
        try {
            $order->update([
                "payment_status" => $request->payment_status,
                "status" => $request->status,
                'purchased_at' => $order->payment_method === 'cash_on_delivery' && $request->payment_status === 'completed' ? now() : null
            ]);

            $order->load(['orderItems.product.addons']);

            return response()->json($order, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
