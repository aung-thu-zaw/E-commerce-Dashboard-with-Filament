<?php

namespace App\Http\Controllers\Admin\AccountManagement\AdminManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class GetResourcesForAdminMangeFormController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $roles = Role::all();

            return response()->json($roles, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
