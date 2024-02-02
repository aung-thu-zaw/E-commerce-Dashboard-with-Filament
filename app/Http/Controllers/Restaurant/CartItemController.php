<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\CartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartItemController extends Controller
{
    public function store(CartItemRequest $request): JsonResponse
    {
        try {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

            $addons = $request->addons;

            $cartItem = CartItem::where('product_id', $request->product_id)
                ->where(function ($query) use ($addons) {
                    if (!empty($addons)) {
                        $query->whereJsonContains('addons', $addons);
                    } else {
                        $query->orWhere('addons', null);
                    }
                })
                ->first();

            if ($cartItem) {
                $cartItem->update(['qty' => $cartItem->qty + $request->qty, 'total_price' => $cartItem->total_price + $request->total_price]);
                return response()->json($cartItem, 201);
            } else {
                $newCartItem = CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $request->product_id,
                    'qty' => $request->qty,
                    'unit_price' => $request->unit_price,
                    'total_price' => $request->total_price,
                    'addons' => count($addons) ? $addons : null,
                ]);
                return response()->json($newCartItem, 200);
            }

        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }


    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        try {
            $cartItem->update([
                'qty' => $request->qty,
                'total_price' => $request->total_price,
            ]);

            return response()->json($cartItem, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function destroy(CartItem $cartItem): Response
    {
        try {
            $cartItem->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
