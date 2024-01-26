<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeManagement\EmployeePositionRequest;
use App\Models\EmployeePosition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EmployeePositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:employee-positions.view', ['only' => ['index']]);
        $this->middleware('permission:employee-positions.create', ['only' => ['store']]);
        $this->middleware('permission:employee-positions.edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:employee-positions.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $employeePositions = EmployeePosition::search(request('search'))
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($employeePositions, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(EmployeePositionRequest $request): JsonResponse
    {
        try {
            $position = EmployeePosition::create($request->validated());
            return response()->json($position, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(EmployeePosition $employeePosition): JsonResponse
    {
        try {
            return response()->json($employeePosition, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(EmployeePositionRequest $request, EmployeePosition $employeePosition): JsonResponse
    {
        try {
            $employeePosition->update($request->validated());
            return response()->json($employeePosition, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(EmployeePosition $employeePosition): Response
    {
        try {
            $employeePosition->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
