<?php

namespace App\Http\Controllers\Admin\Coupons;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChangeCouponStatusController extends Controller
{
    public function __invoke(Request $request, Coupon $coupon): JsonResponse
    {
        try {
            $request->validate(['status' => ['required', Rule::in(['active','inactive'])]]);

            $coupon->update(['status' => $request->status]);

            return response()->json($coupon, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
