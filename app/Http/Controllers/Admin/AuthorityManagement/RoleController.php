<?php

namespace App\Http\Controllers\Admin\AuthorityManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthorityManagement\RoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles.view', ['only' => ['index']]);
        $this->middleware('permission:roles.create', ['only' => ['store']]);
        $this->middleware('permission:roles.edit', ['only' => ['show','update']]);
        $this->middleware('permission:roles.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $roles = Role::search(request('search'))
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($roles, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function show(Role $role): JsonResponse
    {
        try {
            return response()->json($role, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function store(RoleRequest $request): JsonResponse
    {
        try {
            $role = Role::create($request->validated() + ['guard_name' => 'web']);

            return response()->json($role, 201);

        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        try {
            $role->update($request->validated());

            return response()->json($role, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function destroy(Role $role): Response
    {
        try {
            $role->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
