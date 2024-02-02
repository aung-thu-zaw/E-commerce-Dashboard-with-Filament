<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

            $cart->load(['cartItems.product.addons']);

            return response()->json($cart, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
