<?php

namespace App\Http\Controllers\Admin\ManageReservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManageReservation\TableRequest;
use App\Models\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tables.view', ['only' => ['index']]);
        $this->middleware('permission:tables.create', ['only' => ['store']]);
        $this->middleware('permission:tables.edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:tables.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $tables = Table::search(request('search'))
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($tables, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(TableRequest $request): JsonResponse
    {
        try {
            $table = Table::create($request->validated());
            return response()->json($table, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(Table $table): JsonResponse
    {
        try {
            return response()->json($table, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(TableRequest $request, Table $table): JsonResponse
    {
        try {
            $table->update($request->validated());
            return response()->json($table, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(Table $table): Response
    {
        try {
            $table->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
