<?php

namespace App\Http\Controllers\Restaurant\Checkout;

use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use App\Models\ShippingMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetResourcesForCheckoutFormController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $shippingMethods = ShippingMethod::select('name', 'cost')->get();

            $deliveryAreas = DeliveryArea::select('name')->get();

            return response()->json([
                "shippingMethods" => $shippingMethods,
                "deliveryAreas" => $deliveryAreas,
            ], 200);

        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
