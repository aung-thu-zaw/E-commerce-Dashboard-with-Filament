<?php

namespace App\Http\Controllers\Admin\Coupons;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:coupons.view', ['only' => ['index']]);
        $this->middleware('permission:coupons.create', ['only' => ['store']]);
        $this->middleware('permission:coupons.edit', ['only' => ['show','update']]);
        $this->middleware('permission:coupons.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $coupons = Coupon::search(request('search'))
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($coupons, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(CouponRequest $request): JsonResponse
    {
        try {
            $coupon = Coupon::create($request->validated());
            return response()->json($coupon, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(Coupon $coupon): JsonResponse
    {
        try {
            return response()->json($coupon, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(CouponRequest $request, Coupon $coupon): JsonResponse
    {
        try {
            $coupon->update($request->validated());
            return response()->json($coupon, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(Coupon $coupon): Response
    {
        try {
            $coupon->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
