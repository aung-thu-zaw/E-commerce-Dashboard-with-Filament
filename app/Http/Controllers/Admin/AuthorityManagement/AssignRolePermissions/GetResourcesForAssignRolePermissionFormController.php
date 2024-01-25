<?php

namespace App\Http\Controllers\Admin\AuthorityManagement\AssignRolePermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GetResourcesForAssignRolePermissionFormController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $permissionGroups = DB::table('permissions')
            ->select('group')
            ->groupBy('group')
            ->get();

            $permissions = Permission::get();

            return response()->json([
                "permissions" => $permissions,
                "permissionGroups" => $permissionGroups
            ], 200);

        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
