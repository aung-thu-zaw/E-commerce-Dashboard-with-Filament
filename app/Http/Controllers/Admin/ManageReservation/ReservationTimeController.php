<?php

namespace App\Http\Controllers\Admin\ManageReservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManageReservation\ReservationTimeRequest;
use App\Models\ReservationTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ReservationTimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reservation-times.view', ['only' => ['index']]);
        $this->middleware('permission:reservation-times.create', ['only' => ['store']]);
        $this->middleware('permission:reservation-times.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $reservationTimes = ReservationTime::search(request('search'))
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($reservationTimes, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(ReservationTimeRequest $request): JsonResponse
    {
        try {
            $reservationTime = ReservationTime::create($request->validated());

            return response()->json($reservationTime, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(ReservationTime $reservationTime): Response
    {
        try {
            $reservationTime->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
