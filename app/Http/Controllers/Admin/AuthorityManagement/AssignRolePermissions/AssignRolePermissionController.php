<?php

namespace App\Http\Controllers\Admin\AuthorityManagement\AssignRolePermissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthorityManagement\UpdateAssignRolePermissionsRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class AssignRolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:assign-role-permissions.view', ['only' => ['index']]);
        $this->middleware('permission:assign-role-permissions.edit', ['only' => ['show','update']]);
    }

    public function index(): JsonResponse
    {
        try {
            $rolesWithPermissions = Role::search(request('search'))
            ->query(function (Builder $builder) {
                $builder->with('permissions');
            })
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($rolesWithPermissions, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function show(Role $role): JsonResponse
    {
        try {
            $role->load('permissions');
            return response()->json($role, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function update(UpdateAssignRolePermissionsRequest $request, Role $role): JsonResponse
    {
        try {
            $role->permissions()->detach();

            foreach ($request->permission_id as $key => $value) {
                $role->permissions()->attach(['permission_id' => $value]);
            }

            $role->users->each(function ($user) use ($role) {
                $user->syncPermissions($role->permissions);
            });

            $role->load("permissions");

            return response()->json($role, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
