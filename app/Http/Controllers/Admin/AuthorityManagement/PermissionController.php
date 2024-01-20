<?php

namespace App\Http\Controllers\Admin\AuthorityManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permissions.view', ['only' => ['index']]);
    }

    public function index(): JsonResponse
    {
        try {
            $permissions = Permission::search(request('search'))
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($permissions, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
