<?php

namespace App\Http\Controllers\Admin\ManageShipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManageShipping\ShippingMethodRequest;
use App\Models\ShippingMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ShippingMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:shipping-methods.view', ['only' => ['index']]);
        $this->middleware('permission:shipping-methods.create', ['only' => ['store']]);
        $this->middleware('permission:shipping-methods.edit', ['only' => ['show','update']]);
        $this->middleware('permission:shipping-methods.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $shippingMethods = ShippingMethod::search(request('search'))
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($shippingMethods, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(ShippingMethodRequest $request): JsonResponse
    {
        try {
            $shippingMethod = ShippingMethod::create($request->validated());
            return response()->json($shippingMethod, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(ShippingMethod $shippingMethod): JsonResponse
    {
        try {
            return response()->json($shippingMethod, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(ShippingMethodRequest $request, ShippingMethod $shippingMethod): JsonResponse
    {
        try {
            $shippingMethod->update($request->validated());
            return response()->json($shippingMethod, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(ShippingMethod $shippingMethod): Response
    {
        try {
            $shippingMethod->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
