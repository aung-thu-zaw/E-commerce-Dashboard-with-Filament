<?php

namespace App\Http\Controllers\Admin\AccountManagement\AdminManage;

use App\Actions\Admin\AdminManage\CreateAdminAction;
use App\Actions\Admin\AdminManage\UpdateAdminAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AccountManagement\AdminManageRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin-manage.view', ['only' => ['index']]);
        $this->middleware('permission:admin-manage.create', ['only' => ['store']]);
        $this->middleware('permission:admin-manage.edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:admin-manage.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $users = User::search(request('search'))
                ->query(function (Builder $builder) {
                    $builder->filterBy(request(['status', 'role']));
                })
                ->where('role', 'admin')
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($users, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function show(int $userId): JsonResponse
    {
        try {
            $user = User::find($userId);

            $user->load('roles');

            return response()->json($user, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function store(AdminManageRequest $request): JsonResponse
    {
        try {
            $admin = (new CreateAdminAction())->handle($request->validated());

            return response()->json($admin, 201);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function update(AdminManageRequest $request, int $userId): JsonResponse
    {
        try {
            $user = User::find($userId);

            $user = (new UpdateAdminAction())->handle($request->validated(), $user);

            return response()->json($user, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function destroy(int $userId): Response
    {
        try {
            $user = User::find($userId);
            User::deleteAvatar($user->avatar);
            $user->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
