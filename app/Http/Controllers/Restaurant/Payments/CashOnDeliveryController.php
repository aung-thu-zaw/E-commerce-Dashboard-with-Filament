<?php

namespace App\Http\Controllers\Restaurant\Payments;

use App\Http\Controllers\Controller;
use App\Http\Traits\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashOnDeliveryController extends Controller
{
    use Payment;

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $cartItems = auth()->user()->cart->cartItems;

            $order = $this->processOrder(
                'cash_on_delivery',
                $cartItems,
                $request->total_amount
            );

            // $this->sendNewOrderNotification();

            return response()->json($order, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
