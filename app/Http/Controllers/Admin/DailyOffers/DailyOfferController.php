<?php

namespace App\Http\Controllers\Admin\DailyOffers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DailyOfferRequest;
use App\Models\DailyOffer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DailyOfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:daily-offers.view', ['only' => ['index']]);
        $this->middleware('permission:daily-offers.create', ['only' => ['store']]);
        $this->middleware('permission:daily-offers.edit', ['only' => ['show','update']]);
        $this->middleware('permission:daily-offers.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $dailyOffers = DailyOffer::search(request('search'))
            ->with('product:id,name,image')
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($dailyOffers, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(DailyOfferRequest $request): JsonResponse
    {
        try {
            $dailyOffer = DailyOffer::create($request->validated());
            return response()->json($dailyOffer, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(DailyOffer $dailyOffer): JsonResponse
    {
        try {
            return response()->json($dailyOffer, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(DailyOfferRequest $request, DailyOffer $dailyOffer): JsonResponse
    {
        try {
            $dailyOffer->update($request->validated());
            return response()->json($dailyOffer, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(DailyOffer $dailyOffer): Response
    {
        try {
            $dailyOffer->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
