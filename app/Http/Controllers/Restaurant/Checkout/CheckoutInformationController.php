<?php

namespace App\Http\Controllers\Restaurant\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutInformationController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $checkoutInformation = session("checkout-information");

            if($checkoutInformation) {

                return response()->json($checkoutInformation, 200);
            } else {

                return response()->json(["message" => "Checkout Information does not exists."], 404);
            }

        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            session()->put('checkout-information', [
                   'contact_name' => $request->contact_name,
                   'contact_phone' => $request->contact_phone,
                   'address' => $request->address,
                   'shipping_method' => $request->shipping_method,
                   'shipping_cost' => $request->shipping_cost,
                   'delivery_area' => $request->delivery_area,
                   'order_note' => $request->order_note,
               ]);

            $checkoutInformation = session("checkout-information");

            return response()->json($checkoutInformation, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
