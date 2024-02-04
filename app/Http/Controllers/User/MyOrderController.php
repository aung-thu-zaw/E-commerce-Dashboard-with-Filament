<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MyOrderController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $orders = Order::with('orderItems.product:id,name,slug,image')
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate(1)
            ->withQueryString();

            return response()->json($orders, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        try {
            $order->update(["status" => $request->status]);

            return response()->json($order, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
