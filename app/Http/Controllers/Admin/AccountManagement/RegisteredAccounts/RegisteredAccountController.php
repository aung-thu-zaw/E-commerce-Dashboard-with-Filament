<?php

namespace App\Http\Controllers\Admin\AccountManagement\RegisteredAccounts;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RegisteredAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:registered-accounts.view', ['only' => ['index']]);
        $this->middleware('permission:registered-accounts.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $registeredAccounts = User::search(request('search'))
                ->query(function (Builder $builder) {
                    $builder->filterBy(request(['status', 'role']));
                })
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($registeredAccounts, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(User $user): Response
    {
        try {
            User::deleteAvatar($user->avatar);
            $user->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
