<?php

namespace App\Http\Controllers\Admin\ManageShipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManageShipping\DeliveryAreaRequest;
use App\Models\DeliveryArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeliveryAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:delivery-areas.view', ['only' => ['index']]);
        $this->middleware('permission:delivery-areas.create', ['only' => ['store']]);
        $this->middleware('permission:delivery-areas.edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:delivery-areas.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $deliveryAreas = DeliveryArea::search(request('search'))
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($deliveryAreas, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(DeliveryAreaRequest $request): JsonResponse
    {
        try {
            $deliveryArea = DeliveryArea::create($request->validated());

            return response()->json($deliveryArea, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(DeliveryArea $deliveryArea): JsonResponse
    {
        try {
            return response()->json($deliveryArea, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(DeliveryAreaRequest $request, DeliveryArea $deliveryArea): JsonResponse
    {
        try {
            $deliveryArea->update($request->validated());

            return response()->json($deliveryArea, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(DeliveryArea $deliveryArea): Response
    {
        try {
            $deliveryArea->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
